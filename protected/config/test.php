<?php

// Определяем алиасы:
Yii::setPathOfAlias('application', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('public', dirname($_SERVER['SCRIPT_FILENAME']));
Yii::setPathOfAlias('yupe', dirname(__FILE__) . '/../modules/yupe/');
Yii::setPathOfAlias('vendor', dirname(__FILE__) . '/../../vendor/');

return CMap::mergeArray(
    require(dirname(__FILE__) . '/main.php'),
    array(
        'import'     => array(
            'application.components.*',
            'application.models.*',
            'application.modules.yupe.models.*',
            'application.modules.yupe.components.*',
            'application.modules.yupe.controllers.*',
            'application.modules.yupe.components.controllers.*',
            'application.modules.yupe.extensions.tagcache.*',
            'application.modules.yupe.widgets.*',
        ),
        'components' => array(
            'bootstrap'    => array(
                'class'          => 'bootstrap.components.Booster',
                'responsiveCss'  => true,
                'fontAwesomeCss' => true,
            ),
            // Работа с миграциями, обновление БД модулей
            'migrator'     => array('class' => 'yupe\components\Migrator',),
            // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
            // используется лишь после установки Юпи для тестирования:
            'db'           => file_exists(__DIR__ . '/db-test.php') ? require_once __DIR__ . '/db-test.php' : array(),
            'themeManager' => array('basePath' => dirname(__DIR__) . '/../themes',),
            'cache'        => array(
                'class'     => 'CFileCache',
                'behaviors' => array('clear' => array('class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',),),
            ),
            'fixture'      => array('class' => 'system.test.CDbFixtureManager',),
            // конфигурирование urlManager, подробнее: http://www.yiiframework.ru/doc/guide/ru/topics.url
            'urlManager'   => array(
                'class'            => 'yupe\components\urlManager\LangUrlManager',
                'languageInPath'   => true,
                'langParam'        => 'language',
                'urlFormat'        => 'path',
                'showScriptName'   => true,
                // чтобы убрать index.php из url, читаем: http://yiiframework.ru/doc/guide/ru/quickstart.apache-nginx-config
                'cacheID'          => 'cache',
                'useStrictParsing' => true,
                'rules'            => array( // общие правила
                    '/'                                                            => 'install/default/index',
                    '/backend'                                                     => 'yupe/backend/index',
                    '/backend/<action:\w+>'                                        => 'yupe/backend/<action>',
                    '/backend/<module:\w+>/<controller:\w+>'                       => '<module>/<controller>Backend/index',
                    '/backend/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>Backend/<action>',
                    '/backend/<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>Backend/<action>',
                )
            ),
        ),
    )
);
