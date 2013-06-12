<?php
/**
 * Файл основных настроек приложения для production сервера:
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3 (dev)
 * @link     http://yupe.ru
 *
 **/
$config = array(
    'import'       => array(),
    'rules'        => array(),
    'components'   => array(),
    'preload'      => array(),
    'modules'      => array(
        'install' => array(
            'class' => 'application.modules.install.InstallModule',
        ),
    ),
    'cache'        => array(),
    'enableAssets' => false,
);

// Получаем настройки модулей
$files = glob(dirname(__FILE__) . '/modules/*.php');
if (!empty($files)) {
    foreach ($files as $file) {
        $name = pathinfo($file, PATHINFO_FILENAME);

        if (!is_dir(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $name)){
            continue;
        }
        
        $moduleConfig = require $file;

        // Если существует файл с пользовательскими настройками модуля
        // мерджим с текущими настройками:
        if (file_exists($userspace = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'userspace' . DIRECTORY_SEPARATOR . $name . '.php'))
            $moduleConfig = CMap::mergeArray(
                $moduleConfig, require $userspace
            );

        if ($name == 'yupe') {
            if (!YII_DEBUG)
                $config['cache'] = array();
            $config['enableAssets'] = true;
        }

        if ($name == 'install')
            unset($config['modules']['install']);

        if (!empty($moduleConfig['import']))
            $config['import']     = CMap::mergeArray($config['import'], $moduleConfig['import']);
        if (!empty($moduleConfig['rules']))
            $config['rules']      = CMap::mergeArray($config['rules'], $moduleConfig['rules']);
        if (!empty($moduleConfig['component']))
            $config['components'] = CMap::mergeArray($config['components'], $moduleConfig['component']);
        if (!empty($moduleConfig['preload']))
            $config['preload']    = CMap::mergeArray($config['preload'], $moduleConfig['preload']);
        if (!empty($moduleConfig['module']))
            $config['modules']    = CMap::mergeArray($config['modules'], array($name => $moduleConfig['module']));
        if (!empty($moduleConfig['cache']))
            $config['cache']      = CMap::mergeArray($config['cache'], $moduleConfig['cache']);
    }
}

// основной конфигурационный файл Yii и Юпи! (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.application)
return array(
    'basePath'          => dirname(__FILE__) . '/..',
    'defaultController' => 'site',             // контроллер по умолчанию
    'name'              => 'Юпи!',             // название приложения
    'language'          => 'ru',               // язык по умолчанию
    'sourceLanguage'    => 'ru',
    'theme'             => 'default',          // тема оформления по умолчанию
    'charset'           => 'UTF-8',
    'preload'           => CMap::mergeArray(
        array(),
        // preloading components
        $config['preload']
    ),
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../modules/yupe/extensions/booster'),
    ),
    'import'            => CMap::mergeArray(
        array(
            // подключение основых путей
            'application.components.*',
            'application.models.*',
            'application.modules.yupe.components.*',
            'application.modules.yupe.components.controllers.*',
            'application.modules.yupe.widgets.*',
            // подключение путей из модулей
        ), $config['import']
    ),
    // подключение и конфигурирование модулей,
    // подробнее: http://www.yiiframework.ru/doc/guide/ru/basics.module
    'modules' => CMap::mergeArray(
        array(
            'yupe'  => array(
                'class'        => 'application.modules.yupe.YupeModule',
                'brandUrl'     => 'http://yupe.ru?from=engine',
                'enableAssets' => $config['enableAssets'],
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
        ), $config['modules']
    ),
    'behaviors' => array(
        'onBeginRequest' => array('class' => 'application.modules.yupe.components.urlManager.LanguageBehavior'),
    ),
    'params' => require dirname(__FILE__) . '/params.php',
    // конфигурирование основных компонентов (подробнее http://www.yiiframework.ru/doc/guide/ru/basics.component)
    'components' => CMap::mergeArray(
        array(
            // assetsManager:
            'assetManager' => array(
                // Don't use on windows:
                'forceCopy' => false,
            ),
            'bootstrap' => array(
                'class'          => 'bootstrap.components.Bootstrap',
                'coreCss'        => false,
                'responsiveCss'  => false,
                'yiiCss'         => false,
                'jqueryCss'      => false,
                'enableJS'       => false,
                'fontAwesomeCss' => false,
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
            // конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
            'urlManager' => array(
                'class'          => 'application.modules.yupe.components.urlManager.LangUrlManager',
                'languageInPath' => true,
                'langParam'      => 'language',
                'urlFormat'      => 'path',
                'showScriptName' => false, // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
                'cacheID'        => 'cache',
                'rules'          => CMap::mergeArray(
                    CMap::mergeArray(
                        array(
                            // правило переадресации инсталятора
                            '/'                                                           => 'install/default/index',
                        ),
                        $config['rules']
                    ),
                    array(
                        // общие правила
                        '<module:\w+>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                        '<module:\w+>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>'          => '<module>/<controller>/<action>',
                        '<module:\w+>/<controller:\w+>'                                   => '<module>/<controller>/index',
                        '<controller:\w+>/<action:[0-9a-zA-Z_\-]+>'                       => '<controller>/<action>',
                        '<controller:\w+>'                                                => '<controller>/index',
                    )
                ),
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
            'cache' => CMap::mergeArray(
                array(
                    'class' => 'CDummyCache',
                    'behaviors' => array(
                        'clear' => array(
                            'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
                        ),
                    ),
                ), $config['cache']
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
        ), $config['components']
    ),
);
