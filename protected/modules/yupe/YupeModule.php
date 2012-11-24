<?php

/**
 * YupeModule файл класса.
 *
 * @author Andrey Opeykin <aopeykin@gmail.com>
 * @link http://yupe.ru
 * @copyright Copyright &copy; 2012 Yupe!
 * @license BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 *
 * Модуль yupe - основной модуль системы.
 *
 * Модуль yupe содержит в себе все основные компоненты, которые используются другими модулями
 * Это наше ядрышко. Классы ядра рекомендуется именовать с буквы "Y", пример YWebUser.
 *
 * @package yupe.core
 * @since 0.0.1
 */

class YupeModule extends YWebModule
{
    public $siteDescription;
    public $siteName;
    public $siteKeyWords;

    public $backendLayout          = 'column2';
    public $backendTheme           = 'bootstrap';
    public $emptyLayout            = 'empty';
    public $theme;

    public $brandUrl;
    public $coreCacheTime          = 3600;
    public $coreModuleId           = 'yupe';
    public $editorsDir             = 'application.modules.yupe.widgets.editors';
    public $uploadPath             = 'uploads';
    public $editor                 = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';
    public $email;

    public $categoryIcon;
    public $categorySort;

    public $availableLanguages     = "ru,en";
    public $defaultLanguage        = "ru";
    public $defaultBackendLanguage = "ru";

    public $otherCategoryName;

    public function getVersion()
    {
        return '0.4 (dev)';
    }

    public function checkSelf()
    {
        if (Yii::app()->getModule('install'))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'У Вас активирован модуль "Установщик", после установки системы его необходимо отключить! <a href="http://www.yiiframework.ru/doc/guide/ru/basics.module">Подробнее про Yii модули</a>'),
            );

        if (Yii::app()->getModule('gii'))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'У Вас активирован модуль "gii" после установки системы его необходимо отключить! <a href="http://www.yiiframework.ru/doc/guide/ru/basics.module">Подробнее про Yii модули</a>'),
            );

        $uploadPath = Yii::getPathOfAlias('webroot') . '/' . $this->uploadPath;

        if (!is_writable($uploadPath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('yupe', 'Изменить настройки'), array('/yupe/backend/modulesettings/', 'module' => 'yupe')),
                )),
            );

        if (!is_writable(Yii::app()->runtimePath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи!', array('{dir}' => Yii::app()->runtimePath)),
            );

        if (!is_writable(Yii::app()->getAssetManager()->basePath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('yupe', 'Директория "{dir}" не доступна для записи!', array('{dir}' => Yii::app()->getAssetManager()->basePath)),
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
            'backendLayout'          => Yii::t('yupe', 'Layout административной части'),
            'backendTheme'           => Yii::t('yupe', 'Тема административной части'),
            'theme'                  => Yii::t('yupe', 'Тема сайта'),
            'coreCacheTime'          => Yii::t('yupe', 'Время кэширования (сек.)'),
            'editorsDir'             => Yii::t('yupe', 'Каталог для визивиг редакторов'),
            'uploadPath'             => Yii::t('yupe', 'Каталог для загрузки файлов (относительно корня сайта)'),
            'editor'                 => Yii::t('page', 'Визуальный редактор'),
            'email'                  => Yii::t('page', 'Email администратора'),
            'availableLanguages'     => Yii::t('yupe', 'Список доступных языков через запятую (напр. ru,en,de)'),
            'defaultLanguage'        => Yii::t('yupe', 'Язык по умолчанию для сайта'),
            'defaultBackendLanguage' => Yii::t('yupe', 'Язык по умолчанию для панели управления'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'coreCacheTime',
            'theme'                  => $this->getThemes(),
            'backendLayout',
            'backendTheme'           => $this->getThemes(true),
            'siteName',
            'siteDescription',
            'siteKeyWords',
            'editorsDir',
            'uploadPath',
            'editor'                 => $this->getEditors(),
            'email',
            'availableLanguages',
            'defaultLanguage'        => $this->getLanguagesList(),
            'defaultBackendLanguage' => $this->getLanguagesList(),
        );
    }
    
    protected function getLanguagesList()
    {
        $langs = array();
        foreach (explode(',', $this->availableLanguages) as $lang)
            $langs[$lang] = Yii::app()->locale->getLocaleDisplayName($lang);
        return $langs;
    }

    public function getAdminPageLink()
    {
        return array('/yupe/backend/modulesettings/', 'module' => 'yupe');
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
        return Yii::t('yupe', 'Юпи!');
    }

    public function getName()
    {
        return Yii::t('yupe', 'Система');
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
        parent::init();

        $this->otherCategoryName = Yii::t('yupe', 'Остальное');

        $editors = $this->getEditors();
        // если не выбран редактор, но редакторы есть - возмем первый попавшийся
        if (!$this->editor && is_array($editors))
            $this->editor = array_shift($editors);

        $this->setImport(array(
            'yupe.models.*',
            'yupe.components.*',
        ));

        $this->categoryIcon  = array(
            Yii::t('yupe', 'Сервисы') => 'briefcase',
            $this->otherCategoryName  => 'cog',
        );

        $this->categorySort  = array(
            Yii::t('yupe', 'Контент'),
            Yii::t('yupe', 'Структура'),
            Yii::t('yupe', 'Пользователи'),
            Yii::t('yupe', 'Сервисы'),
            Yii::t('yupe', 'Юпи!'),
            Yii::t('yupe', $this->otherCategoryName),
        );
    }

    public function getModules($navigationOnly = false)
    {
        $modules = $yiiModules = $order = array();

        if (count(Yii::app()->modules))
        {
            // Получаем модули и заполняем основные массивы
            foreach (Yii::app()->modules as $key => $value)
            {
                $key    = strtolower($key);
                $module = Yii::app()->getModule($key);

                if (($module !== NULL))
                {
                    if (is_a($module, 'YWebModule'))
                    {
                        $modules[$key]  = $module;
                        $order[(!$module->category)
                            ? $this->otherCategoryName
                            : $module->category
                        ][$key] = $module->adminMenuOrder;
                    }
                    else
                        $yiiModules[$key] = $module;
                }
            }

            $modulesNavigation = Yii::app()->cache->get('YupeModulesNavigation-' . Yii::app()->language);

            if ($modulesNavigation === false)
            {
                // Формируем навигационное меню
                $modulesNavigation = array();

                // Шаблон модуля настройка модулей
                $settings = array(
                    'icon'  => "wrench",
                    'label' => Yii::t('yupe', 'Настройки модулей'),
                    'url'   => array('/yupe/backend/settings/'),
                    'items' => array(),
                );

                // Сортируем категории модулей
                if (count($order) > 1)
                {
                    $categorySort = array_reverse($this->categorySort);

                    foreach ($categorySort as $iValue)
                    {
                        if (isset($order[$iValue]))
                        {
                            $orderValue = $order[$iValue];
                            unset($order[$iValue]);
                            $order = array($iValue => $orderValue) + $order;
                        }
                    }
                }

                // Обходим категории модулей
                foreach ($order as $keyCategory => $valueCategory)
                {
                    $settings['items'][] = array('label' => $keyCategory);

                    // Шаблон категорий
                    $modulesNavigation[$keyCategory] = array(
                        'label' => $keyCategory,
                        'url'   => '#',
                        'items' => array(),
                    );

                    if (isset($this->categoryIcon[$keyCategory]))
                        $modulesNavigation[$keyCategory]['icon'] = $this->categoryIcon[$keyCategory] . " white";

                    // Сортируем модули в категории
                    asort($valueCategory, SORT_NUMERIC);

                    // Обходим модули
                    foreach ($valueCategory as $key => $value)
                    {
                        // собраются подпункты категории "Настройки модулей", кроме пункта Юпи
                        if ($modules[$key]->editableParams && $key != $this->id)
                            $settings['items'][] = array(
                                'icon'  => $modules[$key]->icon,
                                'label' => $modules[$key]->name,
                                'url'   => array('/yupe/backend/modulesettings/', 'module' => $modules[$key]->id),
                            );

                        // проверка на вывод модуля в категориях, потребуется при отключении модуля
                        if (!$modules[$key]->isShowInAdminMenu)
                            continue;

                        // Если нет иконка для данной категории, подставляется иконка первого модуля
                        if (!isset($modulesNavigation[$keyCategory]['icon']) && $modules[$key]->icon)
                            $modulesNavigation[$keyCategory]['icon'] = $modules[$key]->icon . " white";

                        // Шаблон модулей
                        $data = array(
                            'icon'  => $modules[$key]->icon,
                            'label' => $modules[$key]->name,
                            'url'   => $modules[$key]->adminPageLinkNormalize,
                        );

                        // Добавляем подменю у модулей
                        $links = $modules[$key]->navigation;
                        if (is_array($links))
                            $data['items'] = $links;

                        $modulesNavigation[$keyCategory]['items'][$modules[$key]->id] = $data;
                    }
                }

                // Заполняем категорию Юпи!
                $modulesNavigation[$this->category]['items']['settings'] = $settings;

                Yii::app()->cache->set('YupeModulesNavigation-' . Yii::app()->language, $modulesNavigation, Yii::app()->getModule('yupe')->coreCacheTime);
            }
        }

        if (CHtml::normalizeUrl("/" . Yii::app()->controller->route) != '/yupe/backend/index')
        {
            // Устанавливаем активную категорию
            $thisCategory = Yii::app()->controller->module->category
                ? Yii::app()->controller->module->category
                : $this->otherCategoryName;
            $thisCategory = &$modulesNavigation[$thisCategory];
            $thisCategory['active'] = true;

            // Устанавливаем активный модуль
            if (Yii::app()->controller->action->id == 'modulesettings' && isset($_GET['module']) && $_GET['module'] != 'yupe')
            {
                $thisModule = 'settings';
                $thisCategory['items']['yupe']['active'] = false;
            }
            else
                $thisModule = Yii::app()->controller->module->id;

            $thisModule = &$thisCategory['items'][$thisModule];
            $thisModule['icon'] .= ' white';
            $thisModule['active'] = true;

            // Устанавливаем активный пункт подменю модуля
            $moduleItems = &$thisModule['items'];
            if (is_array($moduleItems))
            {
                $thisRoute = CHtml::normalizeUrl(array_merge(array("/" . Yii::app()->controller->route), $_GET));
                foreach ($moduleItems as &$link)
                {
                    if (isset($link['url']) && CHtml::normalizeUrl($link['url']) == $thisRoute && isset($link['icon']))
                        $link['icon'] .= " white";
                }
                unset($link);
            }
            unset($thisModule);
            unset($thisCategory);
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

        $widgets = array();

        if ($path && $handler = opendir($path))
        {
            while (($dir = readdir($handler)))
            {
                if ($dir != '.' && $dir != '..' && !is_file($dir))
                {
                    //посмотреть внутри файл с окончанием Widget.php
                    $files = glob($path . '/' . $dir . '/' . '*Widget.php');

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
        $themes = array();

        if (isset(Yii::app()->themeManager->basePath) && $handler = opendir(Yii::app()->themeManager->basePath))
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