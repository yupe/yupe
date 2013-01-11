<?php
return array(
    'preload'      => array('log'),
    'component'   => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/../db.php'),
    ),
    'rules'        => array(
        '/admin'                                    => 'yupe/backend/index',
        '/admin/modulesettings' 					=> 'yupe/backend/modulesettings',
    	'/admin/modupdate' 							=> 'yupe/backend/modupdate',
    	'/admin/modulechange'			 			=> 'yupe/backend/modulechange',
    	'/admin/help'								=> 'yupe/backend/help',
        // правила контроллера site
        '/'                                         => 'site/index',
        '/<view:\w+>'                               => 'site/page',
    ),
);