<?php
return array(
    'import' =>array(
        'application.modules.yupe.models.*',
        'application.modules.yupe.components.*',
        'application.modules.yupe.extensions.tagcache.*',
    ),
    'cache'     => array(
        'class' => 'CFileCache',
        'behaviors' => array(
            'clear' => array(
                'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
            ),
        ),
    ),
    'preload'   => array('log'),
    'component' => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require(dirname(__FILE__) . '/../db.php'),
    ),
    'rules' => array(
        '/yupe/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
    ),
);