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

class ConfigManager extends CComponent
{
    // Настройки:
    private $_config          = array();
    // Пользовательские настройки:
    private $_userspace       = array();
    // Базовые настройки:
    private $_base             = array();
    // Файл кеша:
    private $_cachefile       = null;
    
    // Основной путь, к приложению:
    public $basePath          = null;
    // Путь к настройкам модулей
    public $modulePath        = null;
    // Путь к пользовательским настройкам модулей
    public $userspacePath     = null;
    // Расположение модулей:
    public $appModules        = null;
    // Категории для слияния
    public $configCategories  = array();
    // Кеш-файл настроек:
    public $cacheFile = 'cached_settings';

    /**
     * Инициализация компонента:
     * 
     * @return void
     */
    public function init()
    {
        // Выходим на несколько каталогов выше:
        $this->basePath      = Yii::getPathOfAlias('application');
        $this->modulePath    = $this->basePath . '/config/modules';
        $this->userspacePath = $this->basePath . '/config/userspace';
        $this->appModules    = $this->basePath . '/modules';

        $this->_base = empty($this->_base)
                        ? require_once $this->basePath . '/config/main.php'
                        : $this->_base;

        $this->_userspace = empty($this->_userspace) && file_exists($this->basePath . '/config/userspace.php')
                        ? require_once $this->basePath . '/config/userspace.php'
                        : $this->_userspace;

        $this->_cachefile = $this->modulePath . '/' . $this->cacheFile . '.php';
    }

    /**
     * Инициализируем компонент, настраиваем
     * пути и принемаем необходимыей параметры:
     * 
     * @param  array  $base      - базовые настройки
     * @param  array  $userspace - пользовательские настройки
     * 
     * @return array - получаем настройки приложения
     */
    public function merge($base = array(), $userspace = array())
    {
        // Мне кажется, нет необходимости
        // изначально сливать настройки:
        //$this->_config    = CMap::mergeArray($base, $userspace);
        $this->_base         = $base;
        $this->_userspace    = $userspace;
        
        // Настройки путей:
        $this->basePath      = Yii::getPathOfAlias('application');
        $this->modulePath    = $this->basePath . '/config/modules';
        $this->userspacePath = $this->basePath . '/config/userspace';
        $this->appModules    = $this->basePath . '/modules';

        // Категории настроек для слития:
        $this->configCategories = $this->configCategories?: array(
            'import', 'rules', 'component', 'preload',
            'modules', 'cache',
        );

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
        if (file_exists(($this->_cachefile = $this->modulePath . '/' . $this->cacheFile . '.php'))) {
            
            // Сливаем базовые настройки   - $this->_base
            // ---------------------------------------------------
            // с настройками из файла кеша - $this->cachedSettings
            // ---------------------------------------------------
            // и наконец, с пользовательскими настройками - $this->_userspace
            unset($this->_base['components']['urlManager']['rules']);
            unset($this->_base['modules']['install']);
            $settings = CMap::mergeArray( // второй мердж (полученные настройки и пользовательские)
                CMap::mergeArray(    // первый мердж (базовые настройки и кеш)
                    $this->_base,
                    $this->cachedSettings()
                ),
                $this->_userspace
            );
        } else {
            $settings = $this->prepareSettings();
        }
        // Выполняем post-merging:
        $this->postMerging($settings);

        return $settings;
    }

    /**
     * Получаем массив настроек из файла-дампа:
     * 
     * @return array - скешированные настройки
     */
    public function cachedSettings()
    {
        try {
            
            $cachedSettings = require $this->_cachefile;

            if (is_array($cachedSettings) === false) {
                $cachedSettings = array();
            }
        
        } catch (Exception $e) {
        
            $cachedSettings = array();
        }

        return $cachedSettings;
    }

    /**
     * Сброс дампа настроек в файл:
     * 
     * @return mixed - bool(true) при успешно завершении
     *                 или (string) с описанием ошибки
     */
    public function dumpSettings()
    {
        // Если выключена опция кеширования настроек - не выполняем его:
        if (defined('\YII_DEBUG') && \YII_DEBUG === true) {
            return true;
        }       

        if(!@file_put_contents($this->_cachefile, '<?php return ' . var_export($this->_config, true) . ';')) {
            throw new CException(Yii::t('YupeModule.yupe', 'Error write cached modules setting in {file}...', array('{file}' => $this->_cachefile)));            
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
        $settings = array();

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
                    $moduleConfig, require $userspace->getRealPath()
                );
            }

            // Если конф.файл для модуля Юпи, то нам необходимо
            // проверить, включён ли DEBUG режим и если включён
            // то необходимо отключить кеширование (в нём нет
            // необходимости при разработке)
            // А также включаем assets'ы (они были отключены на
            // этапе установки системы):
            if ($item->getBaseName('.php') == 'yupe') {
                if (!YII_DEBUG) {
                    $this->_base['components']['cache'] = array();
                }
                $settings['enableAssets'] = true;
            }

            // Если существует конф.файл модуля установщика,
            // значит необходимо исключить данный модуль
            // из базовых настроек:
            if ($item->getBaseName('.php') == 'install') {
                unset($this->_base['components']['urlManager']['rules']['/']);
                unset($this->_base['modules']['install']);
            }

            // Просматриваем основные настройки для
            // слияния:
            foreach ($this->configCategories as $category) {
                switch ($category) {
                    case 'modules':
                        if (!empty($moduleConfig['module'])) {
                            $settings['modules']     = CMap::mergeArray(
                                isset($settings['modules']) ? $settings['modules'] : array(),
                                array($item->getBaseName('.php') => $moduleConfig['module'])
                            );
                        }
                        break;
                    
                    default:
                        // Стандартное слитие:
                        if (!empty($moduleConfig[$category])) {
                            $settings[$category] = CMap::mergeArray(
                                isset($settings[$category]) ? $settings[$category] : array(),
                                $moduleConfig[$category]
                            );
                        }
                        break;
                }

            }
        }

        if (empty($settings)) {
            unset($this->_config['components']['db']);
        }

        return $this->mergeSettings($settings);
    }


    /**
     * Сливаем настройки, кешируем и отдаём
     * приложению:
     * 
     * @param  array  $settings - входящие настройки
     * 
     * @return array - настройки приложения
     */
    public function mergeSettings($settings = array())
    {
        $this->_config = CMap::mergeArray(
            $this->_base,
            array(
                // Preloaded components:
                'preload'  => CMap::mergeArray(
                    isset($this->_config['preload'])
                        ? $this->_config['preload']
                        : array(),
                    isset($settings['preload'])
                        ? $settings['preload']
                        : array()
                ),

                // Подключение основых путей
                'import'  => CMap::mergeArray(
                    isset($this->_config['import'])
                        ? $this->_config['import']
                        : array(),
                    isset($settings['import'])
                        ? $settings['import']
                        : array()
                ),

                // Модули:
                'modules'  => CMap::mergeArray(
                    isset($this->_config['modules'])
                        ? $this->_config['modules']
                        : array(),
                    isset($settings['modules'])
                        ? $settings['modules']
                        : array()
                ),

                // Компоненты:
                'components'  => CMap::mergeArray(
                    isset($this->_config['components'])
                        ? $this->_config['components']
                        : array(),
                    isset($settings['component'])
                        ? $settings['component']
                        : array()
                ),
            )
        );

        if(!array_key_exists('rules',$settings)) {
            $settings['rules'] = array();
        }

        if(!array_key_exists('cache',$settings)) {
            $settings['cache'] = array();
        }

        if(isset($this->_config['components']['urlManager']['rules'])) {
            // Фикс для настроек маршрутизации:
            $this->_config['components']['urlManager']['rules'] = CMap::mergeArray(
                $settings['rules'],
                $this->_config['components']['urlManager']['rules']
            );
        }

        if(isset($this->_config['components']['cache'])) {
            // Слитие настроек для компонента кеширования:
            $this->_config['components']['cache'] = CMap::mergeArray(
                $this->_config['components']['cache'],
                $settings['cache']
            );
        }

        // Сливаем напоследок с пользовательскими
        // настройками:
        $this->_config = CMap::mergeArray(
            $this->_config, $this->_userspace
        );

        // Создание кеша настроек:
        if (($error = $this->dumpSettings()) !== true) {
            throw new Exception($error->getMessage());
        }

        return $this->_config;
    }

    public function postMerging(&$settings = array())
    {
        // Забираем настройки адресации и удаляем элемент:
        $rules = $settings['rules'];
        unset($settings['rules']);

        // Обходим массив Url'ов и убераем схожести:
        foreach ($settings['components']['urlManager']['rules'] as $key => $value) {
            // Обнуляем поиск:
            $search = null;
            
            $search = array_search($value, $rules);

            if (!empty($search) || isset($rules[$key])) {
                unset($settings['components']['urlManager']['rules'][$key]);
            }

            if ($value === false) {
                unset($settings['components']['urlManager']['rules'][$key]);
            }
        }

        // Добавляем новые адреса:
        $settings['components']['urlManager']['rules'] = CMap::mergeArray(
            $rules,
            $settings['components']['urlManager']['rules']
        );
    }

    /**
     * Простая реализация проверки на наличие кеша,
     * в дальнейшем метод может стать больше и сложнее:
     * 
     * @return boolean
     */
    public function isCached()
    {
        $cachedSettingsFile = Yii::getPathOfAlias('application.config.modules')
                            . '/'
                            . $this->cacheFile
                            . '.php';

        return file_exists($cachedSettingsFile) === false;
    }

    /**
     * Сброс кеш-файла настроек:
     * 
     * @return bool - говорящий о результате сброса
     */
    public function flushDump($returnErrors = false)
    {
        $cachedSettingsFile = Yii::getPathOfAlias('application.config.modules') . '/' . $this->cacheFile . '.php';
        
        if ($returnErrors === true && file_exists($cachedSettingsFile) === false) {
            throw new Exception(
                Yii::t(
                    "YupeModule.yupe", "can't unlink file - {file}", array(
                        '{file}' => $cachedSettingsFile
                    )
                ), 1
            );
        }
        
        return @unlink($cachedSettingsFile);
    }
}