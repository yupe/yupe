<?php
/**
 * Менеджер слития базовых и пользовательских конфигурационных файлов модулей,
 * а также последующего кеширования и обработки кеша конфигурации.
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.4
 * @link     http://yupe.ru
 *
 **/

namespace yupe\components;

use Yii;
use CMap;
use GlobIterator;
use SplFileInfo;
use Exception;
use CComponent;
use CException;

/**
 * Class ConfigManager
 * @package yupe\components
 */
class ConfigManager extends CComponent
{
    const ENV_WEB = 'web';
    const ENV_CONSOLE = 'console';

    /**
     * Contains merged configs
     *
     * @var array
     */
    private $_resultConfig = [];

    /**
     * Contains base configs
     *
     * @var array
     */
    private $_baseConfig = [];

    /**
     * @var string
     */
    private $_cacheFilePath;

    /**
     * Path to modules settings
     *
     * @var string
     */
    public $moduleConfigsPath;

    /**
     * Path to user modules configs
     * @var string
     */
    public $userModuleConfigsPath;

    /**
     * Path to modules directory
     *
     * @var string
     */
    public $modulesDir;

    /**
     * Config categories for merge
     *
     * @var array
     */
    public $mergeCategories = [
        'import',
        'rules',
        'component',
        'preload',
        'modules',
        'cache',
        'commandMap',
    ];

    /**
     * Cache key name base
     *
     * @var string
     */
    public $cacheKeyBase = 'cached_settings';

    /**
     * Current environment
     *
     * @var string
     */
    private $_env = self::ENV_WEB;

    /**
     * @param string $_env
     */
    public function setEnv($_env)
    {
        $this->_env = $_env;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initPaths();

        if (empty($this->_baseConfig)) {
            $this->_baseConfig = require_once Yii::getPathOfAlias('application') . '/config/main.php';
        }
    }

    /**
     * @since 0.8
     */
    public function initPaths()
    {
        $application = Yii::getPathOfAlias('application');
        $this->modulesDir = $application . '/modules';
        $this->moduleConfigsPath = $application . '/config/modules';
        $this->userModuleConfigsPath = $application . '/config/userspace';
        $this->_cacheFilePath = $application . '/runtime/' . $this->getCacheFileName() . '.php';
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        if ($this->isCached()) {
            $settings = $this->getCachedSettings();
        } else {
            $settings = $this->prepareSettings();
        }

        return $this->mergeRules($settings);
    }

    /**
     * @return array
     */
    public function getCachedSettings()
    {
        try {
            $cachedSettings = require $this->_cacheFilePath;

            if (is_array($cachedSettings) === false) {
                $cachedSettings = [];
            }

        } catch (Exception $e) {
            $cachedSettings = [];
        }

        return $cachedSettings;
    }

    /**
     * @return bool
     * @throws \CException
     */
    public function dumpSettings()
    {
        // Если выключена опция кеширования настроек - не выполняем его:
        if (defined('\YII_DEBUG') && \YII_DEBUG === true) {
            return true;
        }

        if (!@file_put_contents($this->_cacheFilePath, '<?php return ' . var_export($this->_resultConfig, true) . ';')) {
            throw new CException(Yii::t(
                'YupeModule.yupe',
                'Error write cached modules setting in {file}...',
                ['{file}' => $this->_cacheFilePath]
            ));
        }

        return true;
    }

    /**
     * Готовим настройки приложения:
     *
     * @return array
     */
    public function prepareSettings()
    {
        $settings = [];

        // Запускаем цикл обработки, шагая по конфигурационным файлам
        // сливая их с пользовательскими настройками модулей
        foreach (new GlobIterator($this->moduleConfigsPath . '/*.php') as $item) {

            // Если нет такого модуля, нет необходимости в обработке:
            if (is_dir($this->modulesDir . '/' . $item->getBaseName('.php')) == false) {
                continue;
            }

            $moduleConfig = require $item->getRealPath();

            // Файл пользовательских настроек:
            $userspace = new SplFileInfo($this->userModuleConfigsPath . '/' . $item->getFileName());
            // При наличии файла, сливаем с основным:
            if ($userspace->isFile()) {
                $moduleConfig = CMap::mergeArray(
                    $moduleConfig,
                    require $userspace->getRealPath()
                );
            }

            // Просматриваем основные настройки для
            // слияния:
            foreach ($this->mergeCategories as $category) {
                switch ($category) {
                    case 'modules':
                        if (!empty($moduleConfig['module'])) {
                            $settings['modules'] = CMap::mergeArray(
                                isset($settings['modules']) ? $settings['modules'] : [],
                                [$item->getBaseName('.php') => $moduleConfig['module']]
                            );
                        }

                        break;

                    case 'commandMap':
                        // commandMap заполняем только для консоли
                        if ($this->_env !== self::ENV_CONSOLE) {
                            continue;
                        }
                    default:
                        // Стандартное слитие:
                        if (!empty($moduleConfig[$category])) {
                            $settings[$category] = CMap::mergeArray(
                                isset($settings[$category]) ? $settings[$category] : [],
                                $moduleConfig[$category]
                            );
                        }
                        break;
                }
            }
        }

        //смерджим файл /protected/config/project.php
        return $this->mergeSettings(CMap::mergeArray($settings, Yii::getPathOfAlias('application') . '/config/project.php'));
    }

    /**
     * Инициализируем компонент, настраиваем
     * пути и принемаем необходимыей параметры:
     *
     * @param array $base - базовые настройки
     *
     * @return array - получаем настройки приложения
     */
    public function merge(array $base = [])
    {
        $this->_baseConfig = $base;

        return $this->getSettings();
    }

    /**
     * Сливаем настройки, кешируем и отдаём
     * приложению:
     *
     * @param array $settings - входящие настройки
     * @return array - настройки приложения
     * @throws CException
     * @throws Exception
     */
    public function mergeSettings($settings = [])
    {
        $categoriesForMerge = [
            'preload',
            'import',
            'modules',
            'components',
            'aliases',
            'commandMap'
        ];

        $this->_resultConfig = $this->_baseConfig;

        foreach ($categoriesForMerge as $mergeCategory) {
            $this->_resultConfig = CMap::mergeArray(
                $this->_resultConfig,
                [
                    isset($this->_resultConfig[$mergeCategory])
                        ? $this->_resultConfig[$mergeCategory]
                        : [],
                    isset($settings[$mergeCategory])
                        ? $settings[$mergeCategory]
                        : []
                ]
            );
        }

        if ($this->_env == self::ENV_WEB) {
            unset($this->_resultConfig['commandMap']);
        }

        if (array_key_exists('rules', $settings) === false) {
            $settings['rules'] = [];
        }

        if (array_key_exists('cache', $settings) === false) {
            $settings['cache'] = [];
        }

        if (isset($this->_resultConfig['components']['urlManager']['rules'])) {
            // Фикс для настроек маршрутизации:
            $this->_resultConfig['components']['urlManager']['rules'] = CMap::mergeArray(
                $this->_resultConfig['components']['urlManager']['rules'],
                $settings['rules']
            );
        }

        if (isset($this->_resultConfig['components']['cache'])) {
            // Слитие настроек для компонента кеширования:
            $this->_resultConfig['components']['cache'] = CMap::mergeArray(
                $this->_resultConfig['components']['cache'],
                $settings['cache']
            );
        }

        // Создание кеша настроек:
        if (($error = $this->dumpSettings()) !== true) {
            throw new Exception($error->getMessage());
        }

        return $this->_resultConfig;
    }

    /**
     * @param array $settings
     * @return array
     */
    public function mergeRules($settings = [])
    {
        // Если установлен компонент urlManager (т.е. не консоль)
        if (isset($settings['components']['urlManager'])) {
            // Забираем настройки адресации и удаляем элемент:
            $rules = $settings['rules'];

            unset($settings['rules']);

            // Обходим массив Url'ов и убераем схожести:
            foreach ($settings['components']['urlManager']['rules'] as $key => $value) {

                $search = array_search($value, $rules);

                if (!empty($search) || isset($rules[$key]) || false === $value) {
                    unset($settings['components']['urlManager']['rules'][$key]);
                }
            }

            // Добавляем новые адреса:
            $settings['components']['urlManager']['rules'] = CMap::mergeArray(
                $rules,
                $settings['components']['urlManager']['rules']
            );
        }

        return $settings;
    }

    /**
     * @return boolean
     */
    public function isCached()
    {
        return file_exists($this->_cacheFilePath);
    }

    /**
     * @return boolean Operation result
     */
    public function flushDump()
    {
        return @unlink($this->_cacheFilePath);
    }

    public function getCacheFileName()
    {
        return $this->cacheKeyBase . '_' . $this->_env;
    }
}
