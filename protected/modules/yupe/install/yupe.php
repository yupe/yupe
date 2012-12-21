<?php
return array(
    'preload'      => array('log'),
    'cache'        => 'cache',
    'enableAssets' => true,
    'component'   => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/../db.php'),
    ),
    'rules'        => array(
        '/yupe/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
        // правила контроллера site
        '/'                                         => 'site/index',
        '/<view:\w+>'                               => 'site/page',
    ),
);