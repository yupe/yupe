<?php
/**
 * Файл основных настроек приложения
 *
 * ВНИМАНИЕ! ДАННЫЙ ФАЙЛ ИСПОЛЬЗУЕТСЯ ЯДРОМ YUPE!
 * ИЗМЕНЕНИЯ В ДАННОМ ФАЙЛЕ МОГУТ ПРИВЕСТИ К ПОТЕРЕ РАБОТОСПОСОБНОСТИ
 * Для собственных настроек создайте и используйте "/protected/config/userspace.php"
 * Подробную информацию по использованию "userspace" можно узнать из официальной
 * документации.
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.4
 * @link     http://yupe.ru
 *
 **/

return array(
    'basePath'          => dirname(__FILE__) . '/..',
    'defaultController' => 'site',             // контроллер по умолчанию
    'name'              => 'Юпи!',             // название приложения
    'language'          => 'ru',               // язык по умолчанию
    'sourceLanguage'    => 'ru',
    'theme'             => 'default',          // тема оформления по умолчанию
    'charset'           => 'UTF-8',
    'preload'           => array(),
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../modules/yupe/extensions/booster'),
    ),
    'import' => array(
        // подключение основых путей
        'application.components.*',
        'application.models.*',
        'application.modules.yupe.models.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.components.*',
        'application.modules.yupe.controllers.*',
        'application.modules.yupe.components.controllers.*',
    ),
    // подключение и конфигурирование модулей,
    // подробнее: http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules' => array(
        'install' => array(
            'class' => 'application.modules.install.InstallModule',
        ),
        'yupe'  => array(
            'class'        => 'application.modules.yupe.YupeModule',
            'brandUrl'     => 'http://yupe.ru?from=engine',
            'cache'        => true,
        ),
        // на продакшне gii рекомендуется отключить, подробнее: http://www.yiiframework.com/doc/guide/1.1/en/quickstart.first-app
        /*'gii'   => array(
            'class'          => 'system.gii.GiiModule',
            'password'       => 'giiYupe',
            'generatorPaths' => array(
                'application.modules.yupe.extensions.yupe.gii',
            ),
            'ipFilters'=>array(),
        ),*/
    ),
    'behaviors' => array(
        'onBeginRequest' => array('class' => 'application.modules.yupe.components.urlManager.LanguageBehavior'),
    ),
    'params' => require dirname(__FILE__) . '/params.php',
    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
            'responsiveCss'  => true,
            'fontAwesomeCss' => true,
        ),
        // Работа с миграциями, обновление БД модулей
        'migrator'=>array(
            'class'=>'application.modules.yupe.components.migrator.Migrator',
        ),
        // библиотека для работы с картинками через GD/ImageMagick
        // лучше установите ImageMagick, т.к. он ресайзит анимированные гифы
        'image' => array(
            'class'  => 'application.modules.yupe.extensions.image.CImageComponent',
            'driver' => 'GD',                               // если ImageMagick, надо указать к нему путь ниже
            'params' => array( 'directory' => '/usr/bin' ), // в этой директории должен быть convert
        ),
        'thumbs' => array(
            'class'   => 'application.modules.yupe.extensions.EPhpThumb.EPhpThumb',
            'options' => array('jpegQuality' => 80),
        ),
        'themeManager'       => array(
            'basePath'       => dirname(__DIR__) . '/../themes',
        ),
        // конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
        'urlManager' => array(
            'class'          => 'application.modules.yupe.components.urlManager.LangUrlManager',
            'languageInPath' => true,
            'langParam'      => 'language',
            'urlFormat'      => 'path',
            'showScriptName' => false, // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
            'cacheID'        => 'cache',
            'rules'          => array(
                // общие правила
                '/' => 'install/default/index',
                '<module:\w+>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>'          => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>'                                   => '<module>/<controller>/index',
                '<controller:\w+>/<action:[0-9a-zA-Z_\-]+>'                       => '<controller>/<action>',
                '<controller:\w+>'                                                => '<controller>/index',
            )
        ),
        // конфигурируем компонент CHttpRequest для защиты от CSRF атак, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.security
        // РЕКОМЕНДУЕМ УКАЗАТЬ СВОЕ ЗНАЧЕНИЕ ДЛЯ ПАРАМЕТРА "csrfTokenName"
        // базовый класс CHttpRequest переопределен для загрузки файлов через ajax, подробнее: http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
        'request' => array(
            'class'                  => 'application.modules.yupe.components.YHttpRequest',
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
            'class' => 'CDummyCache',
            'behaviors' => array(
                'clear' => array(
                    'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
                ),
            ),
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
                /*
                array(
                    'class'=>'application.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('127.0.0.1', '46.172.254.123'),
                ),
                //*/
            ),
        ),
        // подключение CURL-обертки, подробнее https://github.com/hackerone/curl
        'curl' => array(
            'class' => 'application.modules.yupe.extensions.curl.Curl'
        ),

        // Подключение компоненты подсветки кода Highlight.js (Подробнее: http://softwaremaniacs.org/soft/highlight/)
        'highlightjs' => array(
            'class'   => 'application.modules.yupe.extensions.highlightjs.Highlightjs',
            'remote' => false,
            'style'=>'github'
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
    ),
);