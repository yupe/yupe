<?php
$import = $rules = $components = $preload = array();
$cache = $enableAssets = false;
$modules = array(
    'install' => array(
        'class' => 'application.modules.install.InstallModule',
    ),
);
$files = glob(dirname(__FILE__) . '/modules/*.php');

foreach ($files as $file)
{
    $config = require_once($file);
    $name   = preg_replace('#^.*/([^\.]*)\.php$#', '$1', $file);

    if (!empty($config['import']))
        $import = array_merge($import, $config['import']);
    if (!empty($config['rules']))
        $rules = array_merge($rules, $config['rules']);
    if (!empty($config['component']))
        $components = array_merge($components, $config['component']);
    if (!empty($config['module']))
        $modules = array_merge($modules, array($name => $config['module']));
    if (!empty($config['preload']))
        $preload = array_merge($preload, $config['preload']);
    if ($name == 'yupe')
    {
        if (!empty($config['cache']))
            $cache = $config['cache'];
        if (!empty($config['enableAssets']))
            $enableAssets = $config['enableAssets'];
    }
    if ($name == 'install')
    {
        if (!empty($config['install']))
            unset($modules['install']);
    }
}

// основной конфигурационный файл Yii и Юпи! (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.application)
return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'defaultController' => 'site',       // контроллер по умолчанию
    'name'              => 'Юпи!',       // название приложения
    'language'          => 'ru',         // язык по умолчанию
    'sourceLanguage'    => 'ru',
    'theme'             => 'default',    // тема оформления по умолчанию
    'preload'           => $preload,     // preloading 'log' component
    'import'            => array_merge(array(
        // подключение основых путей
        'application.components.*',
        // подключение путей из модулей
        'application.modules.yupe.controllers.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',
        'application.modules.yupe.components.*',
        'application.modules.yupe.components.controllers.*',
        'application.modules.yupe.components.validators.*',
        'application.modules.yupe.components.exceptions.*',
    ), $import),
    // подключение и конфигурирование модулей,
    // подробнее: http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules' => array_merge(array(
        'yupe'  => array(
            'class'        => 'application.modules.yupe.YupeModule',
            'brandUrl'     => 'http://yupe.ru?from=engine',
            'enableAssets' => $enableAssets,
            'cache'        => $cache,
        ),
        // на продакшне gii рекомендуется отключить, подробнее: http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app
        'gii'   => array(
            'class'          => 'system.gii.GiiModule',
            'password'       => 'giiYupe',
            'generatorPaths' => array(
                'application.modules.yupe.extensions.yupe.gii',
            ),
            'ipFilters'=>array(),
        ),
    ), $modules),
    'behaviors' => array(
        'onBeginRequest' => array('class' => 'application.modules.yupe.extensions.urlManager.LanguageBehavior'),
        'YupeStartUpBehavior',
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components' => array_merge(array(
        // библиотека для работы с картинками через GD/ImageMagick
        // лучше установите ImageMagick, т.к. он ресайзит анимированные гифы
        'image' => array(
            'class'  => 'application.modules.yupe.extensions.image.CImageComponent',
            'driver' => 'GD',                               // если ImageMagick, надо указать к нему путь ниже
            'params' => array( 'directory' => '/usr/bin' ), // в этой директории должен быть convert
        ),
        // конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
        'urlManager' => array(
            'class'          => 'application.modules.yupe.extensions.urlManager.LangUrlManager',
            'languageInPath' => true,
            'langParam'      => 'language',
            'urlFormat'      => 'path',
            'showScriptName' => false, // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
            'cacheID'        => $cache,
            'rules'          => array_merge($rules, array(
                // правила переадресации
                '/'                                                   => 'install/default/index',
                // общие правила
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>'                       => '<module>/<controller>/index',
                '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
                '<controller:\w+>'                                    => '<controller>/index',
            )),
        ),
        // конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.security
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        // базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее: http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
        'request' => array(
            'class'                  => 'YHttpRequest',
            'enableCsrfValidation'   => true,
            'csrfTokenName'          => 'YUPE_TOKEN',
            'noCsrfValidationRoutes' => array('yupe/backend/AjaxFileUpload'),
            'enableCookieValidation' => true, // подробнее: http://www.yiiframework.com/doc/guide/1.1/ru/topics.security#sec-4
        ),
        // подключение компонента для генерации ajax-ответов
        'ajax' => array(
            'class' => 'application.modules.yupe.components.YAsyncResponse',
        ),
        // настройки кэширования, подробнее http://www.yiiframework.ru/doc/guide/ru/caching.overview
        'cache' => array(
            'class' => 'CFileCache',
        ),
        // параметры логирования, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.logging
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info, trace', // на продакшн лучше оставить error, warning
                ),
                // профайлер запросов к базе данных, на продакшн рекомендуется отключить
                array(
                    'class'        => 'application.modules.yupe.extensions.db_profiler.DbProfileLogRoute',
                    'countLimit'   => 1,    // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),
            ),
        ),
        // подключение CURL-обертки, подробнее https://github.com/hackerone/curl
        'curl' => array(
            'class' => 'application.modules.yupe.extensions.curl.Curl'
        ),
    ), $components),
);