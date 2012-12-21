<?php
return array(
    'preload'      => array('log'),
    'cache'        => 'cache',
    'enableAssets' => true,
    'components'   => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/db.php'),
    ),
    'rules'        => array(
        '/yupe/backend/modulesettings/<module:\w+>'           => 'yupe/backend/modulesettings',
        // правила контроллера site
        '/'                                                   => 'site/index',
        '/<view:\w+>'                                         => 'site/page',
        // общие правила
        '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>'          => '<module>/<controller>/<action>',
        '<module:\w+>/<controller:\w+>'                       => '<module>/<controller>/index',
        '<controller:\w+>/<action:\w+>'                       => '<controller>/<action>',
        '<controller:\w+>'                                    => '<controller>/index',
    ),
);