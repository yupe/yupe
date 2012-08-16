<?php

/**
 * YupeModule файл класса.
 *
 * @author Andrey Opeykin <aopeykin@gmail.com>
 * @link http://yupe.ru
 * @copyright Copyright &copy; 2012 Yupe!
 * @license BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 */
/**
 * Модуль yupe - основной модуль системы.
 *
 * Модуль yupe содержит в себе все основные компоненты, которые используются другими модулями
 * Это наше ядрышко. Классы ядра рекомендуется именовать с буквы "Y", пример YWebUser.
 *
 * @package yupe.core
 * @since 0.0.1
 */

Yii::import('application.modules.yupe.YupeParams');

class YupeModule extends YupeParams
{
    const OTHER_CATEGORY  = 'Остальное';

    public $siteDescription;
    public $siteName;
    public $siteKeyWords;
    public $backendLayout = 'column2';
    public $backendTheme  = 'bootstrap';
    public $emptyLayout   = 'empty';
    public $theme;
    public $brandUrl;
    public $coreCacheTime = 3600;
    public $coreModuleId  = 'yupe';
    public $editorsDir    = 'application.modules.yupe.widgets.editors';
    public $uploadPath    = 'uploads';
    public $editor        = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';
    public $email;
    public $categoryIcon  = array(
        'Сервисы'            => 'briefcase',
        self::OTHER_CATEGORY => 'inbox',
    );
    public $categorySort  = array(
        'Контент', 'Структура', 'Пользователи', 'Сервисы', 'Система', 'Остальное'
    );

    public $availableLanguages = "ru,en";
    public $defaultLanguage = "ru";
    public $defaultBackendLanguage = "ru";

    public function getVersion()
    {
        return '0.0.4';
    }

    public function checkSelf()
    {
        $settings = Settings::model()->fetchModuleSettings('yupe', 'email');        
        if (isset($settings['email']) && $settings['email']->param_value == 'admin@admin.ru')
            return array(
                'type' => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'У Вас не изменен e-mail администратора, указанный, при установке, по умолчанию! {link}', array(
                    '{link}' => CHtml::link(Yii::t('yupe', 'Изменить настройки'), array( '/yupe/backend/modulesettings/', 'module' => 'yupe' )),
                )),
            );

        $uploadPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath))
            return array(
                'type' => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('yupe', 'Изменить настройки'), array( '/yupe/backend/modulesettings/', 'module' => 'yupe' ))
                )),
            );

        if (!is_writable(Yii::app()->runtimePath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи!', array( '{dir}' => Yii::app()->runtimePath )),
            );

        if (!is_writable(Yii::app()->getAssetManager()->basePath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи!', array( '{dir}' => Yii::app()->getAssetManager()->basePath )),
            );

        if (defined('YII_DEBUG') && YII_DEBUG)
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Yii работает в режиме отладки, пожалуйста, отключите его! <br/> <a href="http://www.yiiframework.ru/doc/guide/ru/topics.performance">Подробнее про улучшение производительности Yii приложений</a>'),
            );

        return true;
    }

    public function getParamsLabels()
    {
        return array(
            'siteDescription'        => Yii::t('yupe', 'Описание сайта'),
            'siteName'               => Yii::t('yupe', 'Название сайта'),
            'siteKeyWords'           => Yii::t('yupe', 'Ключевые слова сайта'),
            'backendLayout'          => Yii::t('yupe', 'Вид административной части'),
            'backendTheme'           => Yii::t('yupe', 'Вид административной части'),
            'theme'                  => Yii::t('yupe', 'Тема'),
            'coreCacheTime'          => Yii::t('yupe', 'Время кэширования (сек.)'),
            'editorsDir'             => Yii::t('yupe', 'Каталог для визивиг редакторов'),
            'uploadPath'             => Yii::t('yupe', 'Каталог для загрузки файлов (относительно корня сайта)'),
            'editor'                 => Yii::t('page', 'Визуальный редактор'),
            'email'                  => Yii::t('page', 'Email администратора'),
            'availableLanguages'     => Yii::t('yupe', 'Список доступных языков через запятую (напр. ru,en,de)'),
            'defaultLanguage'        => Yii::t('yupe', 'Язык по-умолчанию для сайта'),
            'defaultBackendLanguage' => Yii::t('yupe', 'Язык по-умолчанию для админки'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'coreCacheTime',
            'theme',
            'backendLayout',
            'backendTheme',
            'siteName',
            'siteDescription',
            'siteKeyWords',
            'editorsDir',
            'uploadPath',
            'editor' => $this->getEditors(),
            'email',
            'availableLanguages',
            'defaultLanguage',
            'defaultBackendLanguage',
        );
    }

    public function getAdminPageLink()
    {
        return CHtml::normalizeUrl('/yupe/backend/modulesettings/', array('module' => 'yupe'));
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'trash', 'label' => Yii::t('yupe', 'Очистить кеш'), 'url' => array('/yupe/backend/cacheflush/')),
            array('icon' => 'picture', 'label' => Yii::t('yupe', 'Оформление'), 'url' => array('/yupe/backend/themesettings/')),
            array('icon' => 'exclamation-sign', 'label' => Yii::t('yupe', 'Помощь'), 'url' => array('/yupe/backend/help/')),
            array('icon' => 'wrench', 'label' => Yii::t('yupe', 'Парметры сайта'), 'url' => array('/yupe/backend/modulesettings/', 'module' => 'yupe')),
        );
    }

    public function getCategory()
    {
        return Yii::t('yupe', 'Система');
    }

    public function getName()
    {
        return Yii::t('yupe', 'Юпи!');
    }

    public function getDescription()
    {
        return Yii::t('yupe', 'Наше маленькое ядрышко =)');
    }

    public function getAuthor()
    {
        return Yii::t('yupe', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('yupe', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('yupe', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "cog";
    }

    public function init()
    {
        parent::runParentInit();

        $editors = $this->getEditors();

        // если не выбран редактор, но редакторы есть - возмем первый попавшийся
        if (!$this->editor && is_array($editors))
            $this->editor = array_shift($editors);

        $this->setImport(array(
            'yupe.models.*',
            'yupe.components.*',
        ));
    }

    public function getModules($navigationOnly = false)
    {
        $modules = $yiiModules = $order = array( );

        if (count(Yii::app()->modules))
        {
            // Получаем модули и заполняем основные массивы
            foreach (Yii::app()->modules as $key => $value)
            {
                $key    = strtolower($key);
                $module = Yii::app()->getModule($key);

                if (!is_null($module))
                {
                    if (is_a($module, 'YWebModule') && (
                        $module->isShowInAdminMenu || $module->editableParams || (
                            !$module->isShowInAdminMenu && is_array($module->checkSelf())
                        )
                    ))
                    {
                        $modules[$key]  = $module;
                        $order[
                            (!$module->category) ? self::OTHER_CATEGORY : $module->category
                        ][$key] = $module->adminMenuOrder;
                    }
                    else
                        $yiiModules[$key] = $module;
                }
            }

            $modulesNavigation = Yii::app()->cache->get('YupeModulesNavigation');
            
            if ($modulesNavigation === false)
            {
                // Формируем навигационное меню
                $modulesNavigation = $orderNew = array( );

                // Шаблон модуля настройка модулей
                $settings = array(
                    'icon'  => "wrench",
                    'label' => Yii::t( 'yupe', 'Настройки модулей' ),
                    'url'   => array( '/yupe/backend/settings/' ),
                    'items' => array( ),
                );

                // Сортируем категории модулей
                array_walk($this->categorySort, function($iValue) use (&$order, &$orderNew)
                {
                    if(isset($order[$iValue]))
                        $orderNew[$iValue] = $order[$iValue];
                });

                $orderNew = array_merge($orderNew, array_diff($order, $this->categorySort));

                // Обходим категории модулей
                foreach ($orderNew as $keyCategory => $valueCategory)
                {
                    $settings['items'][] = array( 'label' => $keyCategory );

                    // Шаблон категорий
                    $modulesNavigation[$keyCategory] = array(
                        'label'       => $keyCategory,
                        'url'         => '#',
                        'items'       => array( ),
                    );

                    if (isset($this->categoryIcon[$keyCategory]))
                        $modulesNavigation[$keyCategory]['icon'] = $this->categoryIcon[$keyCategory];

                    // Сортируем модули в категории
                    asort($valueCategory, SORT_NUMERIC);

                    // Обходим модули
                    foreach ($valueCategory as $key => $value)
                    {
                        // Если нет иконка для данной категории, подставляется иконка первого модуля
                        if(!isset($modulesNavigation[$keyCategory]['icon']) && $modules[$key]->icon)
                            $modulesNavigation[$keyCategory]['icon'] = $modules[$key]->icon;

                        // собраются подпункты категории "Настройки модулей", кроме пункта Юпи
                        if ($modules[$key]->editableParams && $key != $this->id)
                            $settings['items'][] = array(
                                'icon'  => $modules[$key]->icon,
                                'label' => $modules[$key]->name,
                                'url'   => array(
                                    '/yupe/backend/modulesettings/',
                                    'module' => $modules[$key]->id,
                                ),
                            );

                        // проверка на вывод модуля в категориях, потребуется при отключении модуля
                        if (!$modules[$key]->isShowInAdminMenu)
                            continue;

                        // Шаблон модулей
                        $data = array(
                            'icon'  => $modules[$key]->icon,
                            'label' => $modules[$key]->name,
                            'url'   => array( $modules[$key]->adminPageLink ),
                        );

                        // Добавляем подменю у модулей
                        $links = $modules[$key]->navigation;
                        if (is_array($links))
                            $data['items'] = $links;

                        $modulesNavigation[$keyCategory]['items'][$modules[$key]->id] = $data;
                    }
                }

                // Заполняем категорию система
                $modulesNavigation[$this->category]['items']['settings'] = $settings;

                Yii::app()->cache->set('YupeModulesNavigation', $modulesNavigation, Yii::app()->getModule('yupe')->coreCacheTime);
            }
        }

        $thisRoute = CHtml::normalizeUrl(array_merge(array("/" . Yii::app()->controller->route), $_GET));
        if($thisRoute != '/index.php/yupe/backend/index')
        {
            // Устанавливаем активную категорию
            $thisCategory = Yii::app()->controller->module->category
                ? Yii::app()->controller->module->category
                : self::OTHER_CATEGORY;
            $thisCategory = &$modulesNavigation[$thisCategory];

            $thisCategory['active'] = true;

            // Устанавливаем активный модуль
            $thisModule = (Yii::app()->controller->action->id == 'modulesettings')
                ? 'settings'
                : Yii::app()->controller->module->id;
            $thisModule = &$thisCategory['items'][$thisModule];

            $thisModule['icon'] .= ' white';
            $thisModule['active'] = true;

            // Устанавливаем активный пункт подменю модуля
            $moduleItems = &$thisModule['items'];
            if(is_array($moduleItems))
            {
                foreach($moduleItems as &$link)
                {
                    if ( isset($link['url']) && CHtml::normalizeUrl($link['url']) == $thisRoute && isset($link['icon']) )
                        $link['icon'] .= " white";
                }
                unset($link);
            }
        }

        return ($navigationOnly === true) ? $modulesNavigation : array(
            'modules'           => $modules,
            'yiiModules'        => $yiiModules,
            'modulesNavigation' => $modulesNavigation,
        );
    }

    /**
     * Получает полный алиас нужного лайаута бэкенда с учетом темы
     *
     * @since 0.0.4
     * @param string $layoutName Название лайаута, если не задан - берется по-умолчанию для бекенда
     * @return string Полный путь к лайауту
     */
    function getBackendLayoutAlias($layoutName = '')
    {
        if ($this->backendTheme)
            return 'webroot.themes.backend_' . $this->backendTheme . '.views.yupe.layouts.' . ($layoutName ? $layoutName : $this->backendLayout);
        else
            return 'application.modules.yupe.views.layouts.' . ($layoutName ? $layoutName : $this->backendLayout);
    }

    /**
     * Метод возвращает список доступных для использования в панели управления визуальных редакторов
     *
     * @since 0.0.4
     * @todo возможно, стоит добавить кэширование чтобы каждый раз не ходить по файловой системе
     *
     * Для добавления нового редатора необходимо:
     * Скопировать каталог с виджетом редактора в application.modules.yupe.widgets.editors
     * php-файл с виджетом должен иметь имя *Widget.php, например "EImperaviRedactorWidget"
     *
     */
    public function getEditors()
    {
        $path = Yii::getPathOfAlias($this->editorsDir);

        $widgets = array( );

        if ($path && $handler = opendir($path))
        {
            while (($dir = readdir($handler)))
            {
                if ($dir != '.' && $dir != '..' && !is_file($dir))
                {
                    //посмотреть внутри файл с окончанием Widget.php
                    $files = glob($path . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . '*Widget.php');

                    if (count($files) == 1)
                    {
                        $editor = $this->editorsDir . '.' . $dir . '.' . basename(array_shift($files), '.php');

                        $widgets[$editor] = $editor;
                    }
                }
            }

            closedir($handler);
        }

        return $widgets;
    }

    /**
     * Метод возвращает доступные темы оформления
     *
     * @param bool $backend - если установлен в true - вернет темы оформления для панели управления, иначе - для публичной части сайта
     * @return array список доступных тем
     * @since 0.0.4
     * @todo возможно, стоит добавить кэширование чтобы каждый раз не ходить по файловой системе
     *
     * Для добавления новой темы необходимо:
     * Прочитать http://yiiframework.ru/doc/guide/ru/topics.theming
     * Скопировать тему в каталог  WebRoot/themes или аналогичный (настройки themeManager)
     * Название каталога с темой для панели управления должно начинаться с префикса "backend_", например "backend_bootstrap"
     *
     */
    public function getThemes($backend = false)
    {
        $themes = array( );

        if ($handler = opendir(Yii::app()->themeManager->basePath))
        {
            while (($file = readdir($handler)))
            {
                if ($file != '.' && $file != '..' && !is_file($file))
                {
                    if ("backend_" == substr($file, 0, 8))
                    {
                        if ($backend)
                        {
                            $file = str_replace("backend_", "", $file);

                            $themes[$file] = $file;
                        }
                    }
                    else if (!$backend)
                        $themes[$file] = $file;
                }
            }

            closedir($handler);
        }

        return $themes;
    }
}
