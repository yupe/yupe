<?php
Yii::setPathOfAlias('application', __DIR__ . '/../');
Yii::setPathOfAlias('yupe', __DIR__ . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', __DIR__ . '/../../vendor/');
Yii::setPathOfAlias('themes', __DIR__ . '/../../themes/');

return [
    // У вас этот путь может отличаться. Можно подсмотреть в config/main.php.
    'basePath' => dirname(__DIR__),
    'name' => 'Cron',
    'preload' => ['log'],
    'commandMap' => [
        'migrate' => [
            'class' => 'vendor.yiiext.migrate-command.EMigrateCommand',
            'migrationPath' => 'application.modules.yupe.install.migrations',
            'migrationTable' => '{{migrations}}',
            'applicationModuleName' => 'yupe',
            'migrationSubPath' => 'install.migrations',
            'connectionID' => 'db',
            'templateFile' => 'application.modules.yupe.migrations.migration-template',
        ],
    ],
    'import' => [
        'application.commands.*',
        'application.components.*',
        'application.models.*',
    ],
    'aliases' => [
        'webroot' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'public',
    ],
    // Перенаправляем журнал для cron-а в отдельные файлы
    'components' => [
        'moduleManager' => ['class' => 'yupe\components\ModuleManager'],
        'configManager' => ['class' => 'yupe\components\ConfigManager'],
        // Работа с миграциями, обновление БД модулей
        'migrator' => ['class' => 'yupe\components\Migrator'],
        'themeManager' => [
            'class' => 'CThemeManager',
            'basePath' => dirname(__DIR__) . '/../themes',
            'themeClass' => 'yupe\components\Theme'
        ],
        'request' => [
            'class' => 'yupe\components\HttpRequest',
            'enableCsrfValidation' => true,
            'csrfCookie' => ['httpOnly' => true],
            'csrfTokenName' => 'YUPE_TOKEN',
            'enableCookieValidation' => true,
            // подробнее: http://www.yiiframework.com/doc/guide/1.1/ru/topics.security#sec-4
        ],
        // компонент для отправки почты
        'mail' => [
            'class' => 'yupe\components\Mail',
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'logFile' => 'cron.log',
                    'levels' => 'error, warning, info',
                ],
                [
                    'class' => 'CFileLogRoute',
                    'logFile' => 'cron_trace.log',
                    'levels' => 'trace',
                ],
            ],
        ],
        'cache' => [
            'class' => 'CDummyCache',
            'behaviors' => [
                'clear' => [
                    'class' => 'TaggingCacheBehavior',
                ],
            ],
        ],
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : []
    ],
    'modules' => ['yupe' => ['class' => 'application.modules.yupe.YupeModule', 'cache' => true,],]
];
