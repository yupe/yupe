<?php
return array(
    'import' =>array(
        'application.modules.yupe.components.*',
        'application.modules.yupe.components.controllers.*',
        'application.modules.yupe.components.validators.*',
        'application.modules.yupe.components.exceptions.*',
        'application.modules.yupe.extensions.tagcache.*',
        'application.modules.yupe.widgets.*',
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',
    ),
    'cache'     => array(
        'class' => 'CFileCache',
        'behaviors' => array(
            'clear' => array(
                'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
            ),
        ),
    ),
    'preload'   => array('log','bootstrap'),
    'component' => array(
        'bootstrap' => array(
            'class'          => 'application.modules.yupe.extensions.booster.components.Bootstrap',
            'fontAwesomeCss' => true,
        ),
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require dirname(__FILE__) . '/../db.php',
    ),
    'rules' => array(
        '/yupe/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
    ),
);