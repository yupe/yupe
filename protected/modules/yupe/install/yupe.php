<?php
return array(
    'preload'      => array('log'),
    'component'   => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/../db.php'),
    ),
    'rules'        => array(
        '/yupe/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
    	'/admin'                                    => 'yupe/backend/index',
        // правила контроллера site
        '/'                                         => 'site/index',
        '/<view:\w+>'                               => 'site/page',
    ),
);