<?php
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../../vendor/');

    return array(
    // У вас этот путь может отличаться. Можно подсмотреть в config/main.php.
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'              => 'Cron',
    'preload'           => array('log'),
    'commandMap'        => array(

    ),
    'import' => array(
        'application.commands.*',
        'application.components.*',
        'application.models.*',
        'application.modules.queue.models.*',
        'application.modules.yupe.extensions.tagcache.*',
    ),
    // Перенаправляем журнал для cron-а в отдельные файлы
    'components' => array(
         // компонент для отправки почты
        'mail' => array(
            'class' => 'yupe\components\Mail',
        ),
        'migrator'=>array(
            'class'=>'yupe\components\Migrator',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'logFile' => 'cron.log',
                    'levels' => 'error, warning, info',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'logFile' => 'cron_trace.log',
                    'levels' => 'trace',
                ),
            ),
        ),

        'cache' => array(
            'class' => 'CDummyCache',
            'behaviors' => array(
                'clear' => array(
                    'class' => 'TaggingCacheBehavior',
                ),
            ),
        ),

        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => file_exists(__DIR__ . '/db.php') ? require_once __DIR__ . '/db.php' : array(),
        'ls' => file_exists(__DIR__ . '/ls.php') ? require_once __DIR__ . '/ls.php' : array(),
    ),
    'modules' => array(
        'user' => array(
            'class' => 'application.modules.user.UserModule',
        ),
        'blog' => array(
            'class' => 'application.modules.blog.BlogModule',
        ),
        'yupe'  => array(
            'class'        => 'application.modules.yupe.YupeModule',
            'brandUrl'     => 'http://yupe.ru?from=engine',
            'cache'        => true,
        ),
    )
);