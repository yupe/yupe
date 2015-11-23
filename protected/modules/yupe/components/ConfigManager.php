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
class ConfigManager extends \CApplicationComponent
{
    /**
     *
     */
    const ENV_WEB = 'web';

    /**
     *
     */
    const ENV_CONSOLE = 'console';
    // Настройки:
    /**
     * @var array
     */
    private $_config = [];
    // Базовые настройки:
    /**
     * @var array
     */
    private $_base = [];
    // Файл кеша:
    /**
     * @var null
     */
    private $_cacheFilePath = null;
    // Основной путь, к приложению:
    /**
     * @var null
     */
    public $basePath = null;
    // Путь к настройкам модулей
    /**
     * @var null
     */
    public $modulePath = null;
    // Путь к пользовательским настройкам модулей
    /**
     * @var null
     */
    public $userspacePath = null;
    // Расположение модулей:
    /**
     * @var null
     */
    public $appModules = null;
    // Категории для слияния
    /**
     * @var array
     */
    public $configCategories = [
        'import',
        'rules',
        'component',
        'preload',
        'modules',
        'cache',
        'commandMap',
    ];
    // Кеш-файл настроек:
    /**
     * @var string
     */
    public $cacheFileName = 'cached_settings';

    /**
     * @var string
     */
    protected $env = self::ENV_WEB;

    /**
     * @param $env
     */
    public function sentEnv($env)
    {
        $this->env = $env;
    }

    /**
     * Инициализация компонента:
     *
     * @return void
     */
    public function init()
    {
        $this->initPath();

        $this->_base = empty($this->_base)
            ? require_once $this->basePath . '/config/main.php' : $this->_base;
    }

    /**
     * @since 0.8
     */
    public function initPath()
    {
        $this->basePath = Yii::getPathOfAlias('application');
        $this->modulePath = $this->basePath . '/config/modules';
        $this->userspacePath = $this->basePath . '/config/userspace';
        $this->appModules = $this->basePath . '/modules';

        // Задаем название файла кеша для настроек
        $this->cacheFileName .= '_' . $this->env;
        $this->_cacheFilePath = Yii::getPathOfAlias('application.runtime'). DIRECTORY_SEPARATOR . $this->cacheFileName . '.php';
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
        $this->_base = $base;
        // Настройки путей:
        $this->initPath();

        return $this->getSettings();
    }

    /**
     * Получение настроек из кеш-файла или, запускаем обработчик
     * на создание массива настроек приложения:
     *
     * @return array - настройки приложения
     */
    public function getSettings()
    {
        if ($this->isCached()) {
            $settings = $this->cachedSettings();
        } else {
            $settings = $this->prepareSettings();
        }

        return $this->mergeRules($settings);
    }

    /**
     * Получаем массив настроек из файла-дампа:
     *
     * @return array - скешированные настройки
     */
    public function cachedSettings()
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

        if (!@file_put_contents($this->_cacheFilePath, '<?php return ' . var_export($this->_config, true) . ';')) {
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
     * @return array - настройки приложения
     */
    public function prepareSettings()
    {

        $settings = [];

        // Запускаем цикл обработки, шагая по конфигурационным файлам
        // сливая их с пользовательскими настройками модулей
        foreach (new GlobIterator($this->modulePath . '/*.php') as $item) {

            // Если нет такого модуля, нет необходимости в обработке:
            if (is_dir($this->appModules . '/' . $item->getBaseName('.php')) == false) {
                continue;
            }

            $moduleConfig = require $item->getRealPath();

            // Файл пользовательских настроек:
            $userspace = new SplFileInfo($this->userspacePath . '/' . $item->getFileName());
            // При наличии файла, сливаем с основным:
            if ($userspace->isFile()) {
                $moduleConfig = CMap::mergeArray(
                    $moduleConfig,
                    require $userspace->getRealPath()
                );
            }

            // Просматриваем основные настройки для
            // слияния:
            foreach ($this->configCategories as $category) {
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
                        if ($this->env !== self::ENV_CONSOLE) {
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
        return $this->mergeSettings(CMap::mergeArray($settings, require $this->basePath . '/config/project.php'));
    }

    /**
     * Сливаем настройки, кешируем и отдаём
     * приложению:
     *
     * @param array $settings - входящие настройки
     *
     * @return array - настройки приложения
     */
    public function mergeSettings($settings = [])
    {

        $this->_config = CMap::mergeArray(
            $this->_base,
            [
                // Preloaded components:
                'preload'    => CMap::mergeArray(
                        isset($this->_config['preload'])
                            ? $this->_config['preload']
                            : [],
                        isset($settings['preload'])
                            ? $settings['preload']
                            : []
                    ),
                // Подключение основых путей
                'import'     => CMap::mergeArray(
                        isset($this->_config['import'])
                            ? $this->_config['import']
                            : [],
                        isset($settings['import'])
                            ? $settings['import']
                            : []
                    ),
                // Модули:
                'modules'    => CMap::mergeArray(
                        isset($this->_config['modules'])
                            ? $this->_config['modules']
                            : [],
                        isset($settings['modules'])
                            ? $settings['modules']
                            : []
                    ),
                // Компоненты:
                'components' => CMap::mergeArray(
                        isset($this->_config['components'])
                            ? $this->_config['components']
                            : [],
                        isset($settings['component'])
                            ? $settings['component']
                            : []
                    ),
                // Алиасы
                'aliases' => CMap::mergeArray(
                    isset($this->_config['aliases'])
                        ? $this->_config['aliases']
                        : [],
                    isset($settings['aliases'])
                        ? $settings['aliases']
                        : []
                ),
                // Консольные команды:
                'commandMap' => CMap::mergeArray(
                        isset($this->_config['commandMap'])
                            ? $this->_config['commandMap']
                            : [],
                        isset($settings['commandMap'])
                            ? $settings['commandMap']
                            : []
                    ),
            ]
        );

        if ($this->env == self::ENV_WEB) {
            unset($this->_config['commandMap']);
        }

        if (!array_key_exists('rules', $settings)) {
            $settings['rules'] = [];
        }

        if (!array_key_exists('cache', $settings)) {
            $settings['cache'] = [];
        }

        if (isset($this->_config['components']['urlManager']['rules'])) {
            // Фикс для настроек маршрутизации:
            $this->_config['components']['urlManager']['rules'] = CMap::mergeArray(
                $this->_config['components']['urlManager']['rules'],
                $settings['rules']
            );
        }

        if (isset($this->_config['components']['cache'])) {
            // Слитие настроек для компонента кеширования:
            $this->_config['components']['cache'] = CMap::mergeArray(
                $this->_config['components']['cache'],
                $settings['cache']
            );
        }

        // Создание кеша настроек:
        if (($error = $this->dumpSettings()) !== true) {
            throw new Exception($error->getMessage());
        }

        return $this->_config;
    }

    /**
     * @param array $settings
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
     * Простая реализация проверки на наличие кеша,
     * в дальнейшем метод может стать больше и сложнее:
     *
     * @return boolean
     */
    public function isCached()
    {
        return file_exists($this->_cacheFilePath);
    }

    /**
     * Сброс кеш-файла настроек:
     *
     *
     *
     */
    public function flushDump()
    {
        return @unlink($this->_cacheFilePath);
    }
}
