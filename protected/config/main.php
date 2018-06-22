<?php

/**
 * Main configurations for application
 *
 * ATTENTION! THE CURRENT FILE IS USED IN YUPE CORE!
 * CHANGES OF THIS FILE CAN LEAD TO BREAKAGE OF APPLICATION
 * For yours own configuration create and use file `/protected/config/userspace.php`
 * @link http://yupe.ru/docs/yupe/userspace.config.html
 *
 * @category YupeConfig
 * @package  Yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/

// Set aliases:
Yii::setPathOfAlias('application', __DIR__ . '/../');
Yii::setPathOfAlias('public', dirname($_SERVER['SCRIPT_FILENAME']));
Yii::setPathOfAlias('yupe', __DIR__ . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', __DIR__ . '/../../vendor/');
Yii::setPathOfAlias('themes', __DIR__ . '/../../themes/');

return [
    'basePath' => __DIR__ . '/..',
    // Default controller
    'defaultController' => 'site',
    // Application name
    'name' => 'Yupe!',
    // Default language
    'language' => 'ru',
    'sourceLanguage' => 'en',
    // Default theme
    'theme' => 'default',
    'layout' => 'yupe',
    'charset' => 'UTF-8',
    'controllerNamespace' => 'application\controllers',
    'aliases' => [
        'bootstrap' => realpath(Yii::getPathOfAlias('vendor') . '/clevertech/yii-booster/src')
    ],
    'import' => [
        'application.modules.yupe.extensions.tagcache.*',
        'vendor.yiiext.migrate-command.EDbMigration'
    ],
    /**
     * Enabling and configuration of modules
     * @link http://www.yiiframework.ru/doc/guide/ru/basics.module
     */
    'modules' => [
        'yupe' => [
            'class' => 'application.modules.yupe.YupeModule',
            'cache' => true
        ],
    ],
    'behaviors' => [
        'languageBehavior' => [
            'class' => 'yupe\components\urlManager\LanguageBehavior'
        ]
    ],
    'params' => CMap::mergeArray(
        require __DIR__ . '/params.php',
        is_file(__DIR__ . '/params-local.php') ? require __DIR__ . '/params-local.php' : []
    ),
    /**
     * Configuration base components
     * @link http://www.yiiframework.ru/doc/guide/ru/basics.component
     */
    'components' => [
        'viewRenderer' => [
            'class' => 'vendor.yiiext.twig-renderer.ETwigViewRenderer',
            'twigPathAlias' => 'vendor.twig.twig.lib.Twig',
            'fileExtension' => '.twig',
            'options' => ['autoescape' => true],
            'globals' => ['html' => 'CHtml'],
            'filters' => ['jencode' => 'CJSON::encode']
        ],
        /**
         * Database settings be used only after Yupe install         *
         * @link http://www.yiiframework.ru/doc/guide/ru/database.overview
         */
        'db' => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : [],
        'moduleManager' => ['class' => 'yupe\components\ModuleManager'],
        'eventManager' => ['class' => 'yupe\components\EventManager'],
        'configManager' => ['class' => 'yupe\components\ConfigManager'],
        // Migrations and update DB modules
        'migrator' => ['class' => 'yupe\components\Migrator'],
        'uploadManager' => ['class' => 'yupe\components\UploadManager'],
        'bootstrap' => [
            'class' => 'bootstrap.components.Booster',
            'responsiveCss' => true,
            'fontAwesomeCss' => true,
            'coreCss' => true 
        ],
        'themeManager' => [
            'class' => 'CThemeManager',
            'basePath' => dirname(__DIR__) . '/../themes',
            'themeClass' => 'yupe\components\Theme'
        ],
        'cache' => [
            'class' => 'CFileCache',
            'behaviors' => ['clear' => ['class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior']]
        ],
        /**
         * Configuration of urlManager
         * @link http://www.yiiframework.ru/doc/guide/ru/topics.url
         */
        'urlManager' => [
            'class' => 'yupe\components\urlManager\LangUrlManager',
            'langParam' => 'language',
            'urlFormat' => 'path',
            'urlSuffix' => '',
            /**
             * Removing index.php from url
             * @link http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
             */
            'showScriptName' => false,
            'cacheID' => 'cache',
            'useStrictParsing' => true,
            'rules' => [ // Main rules
                '/' => '/site/index',
                // For correct work of installer
                '/install/default/<action:\w+>' => '/install/default/<action>',
                '/backend' => '/yupe/backend/index',
                '/backend/login' => '/user/account/backendlogin',
                '/backend/<action:(AjaxFileUpload|AjaxImageUpload|AjaxImageUploadCKE|index|settings|flushDumpSettings|modulesettings|saveModulesettings|themesettings|modupdate|help|ajaxflush|transliterate)>' => '/yupe/backend/<action>',
                '/backend/<module:\w+>/<controller:\w+>' => '/<module>/<controller>Backend/index',
                '/backend/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '/<module>/<controller>Backend/<action>',
                '/backend/<module:\w+>/<controller:\w+>/<action:\w+>' => '/<module>/<controller>Backend/<action>',
            ]
        ],
        /**
         * Configuration of CHttpRequest component for secure from CSRF attacks
         * @link http://www.yiiframework.ru/doc/guide/ru/topics.security
         *
         * RECOMMENDED USE OWN VALUE FOR `csrfTokenName`
         *
         * CHttpRequest class be extended for use AJAX
         * @link http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
         *
         * @link http://www.yiiframework.com/doc/guide/1.1/ru/topics.security#sec-4
         */
        'request' => [
            'class' => 'yupe\components\HttpRequest',
            'enableCsrfValidation' => true,
            'csrfCookie' => ['httpOnly' => true],
            'csrfTokenName' => 'YUPE_TOKEN',
            'enableCookieValidation' => true
        ],
        'session' => ['cookieParams' => ['httponly' => true]],
        /**
         * Configuration of logging
         * @link http://www.yiiframework.ru/doc/guide/ru/topics.logging
         */
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    // On production recommended use only `error, warning`
                    'levels' => 'error, warning, info, trace, profile',
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ]
    ],
    /**
     * @link http://docs.yupe.ru/userspace.config/
     */
    'rules' => [
    ]
];
