<?php
return array(
    'import' =>array(
        'application.modules.yupe.components.validators.*',
        'application.modules.yupe.components.exceptions.*',
        'application.modules.yupe.extensions.tagcache.*',
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
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require dirname(__FILE__) . '/../db.php',
        'bootstrap' => array(
            'coreCss'        => true,
            'responsiveCss'  => true,
            'yiiCss'         => true,
            'jqueryCss'      => true,
            'enableJS'       => true,
            'fontAwesomeCss' => true,
        ),
    ),
    'rules' => array(
        '/yupe/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
    ),
);