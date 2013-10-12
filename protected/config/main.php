<?php

// Определяем алиасы:
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../../vendor/');

return array(
    'basePath'          => dirname(__FILE__) . '/..',
    'defaultController' => 'site',             // контроллер по умолчанию
    'name'              => 'Yupe!',             // название приложения
    'language'          => 'ru',               // язык по умолчанию
    'sourceLanguage'    => 'en',
    'theme'             => 'default',          // тема оформления по умолчанию
    'charset'           => 'UTF-8',
    'preload'           => defined('YII_DEBUG') && YII_DEBUG ? array('debug') : array(),
    'aliases' => array(
        'bootstrap' => realpath(Yii::getPathOfAlias('vendor') . '/clevertech/yii-booster/src'),
    ),
    'import' => array(
        // подключение основых путей
        'application.modules.yupe.models.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.controllers.*',
        'application.modules.yupe.extensions.tagcache.*',
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
        'debug' => array(
            'class'   => 'vendor.zhuravljov.yii2-debug.Yii2Debug',
        ),
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        // используется лишь после установки Юпи:
        'db'        => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : array(),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
            'responsiveCss'  => true,
            'fontAwesomeCss' => true,
        ),
        'configManager' => array(
            'class' => 'yupe\components\ConfigManager',
        ),
        // Работа с миграциями, обновление БД модулей
        'migrator'=>array(
            'class'=>'yupe\components\Migrator',
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
                '/'                                                               => 'install/default/index',
                '/backend'                                                        => 'yupe/backend/index',
                '/backend/<action:\w+>'                                           => 'yupe/backend/<action>',
                '/backend/<module:\w+>/<controller:\w+>'                          => '<module>/<controller>Backend/index',
                '/backend/<module:\w+>/<controller:\w+>/<action:\w+>'             => '<module>/<controller>Backend/<action>',
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
            'class'                  => 'yupe\components\HttpRequest',
            'enableCsrfValidation'   => true,
            'csrfTokenName'          => 'YUPE_TOKEN',
            'noCsrfValidationRoutes' => array('yupe/backend/AjaxFileUpload'),
            'enableCookieValidation' => true, // подробнее: http://www.yiiframework.com/doc/guide/1.1/ru/topics.security#sec-4
        ),
        // подключение компонента для генерации ajax-ответов
        'ajax' => array(
            'class' => 'yupe\components\AsyncResponse',
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
            ),
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
    'rules'      => array(
        // Настройки для урлов приложения
        // (использовать лишь в userspace)
        // Пример:
        // '<slug>.html' => 'page/page/show',
    ),
);
