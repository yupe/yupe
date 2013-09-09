<?php
return array(
    'import' =>array(
        'application.modules.engine.components.validators.*',
        'application.modules.engine.components.exceptions.*',
        'application.modules.engine.extensions.tagcache.*',
        'application.modules.engine.helpers.*',
        'application.modules.engine.models.*',
    ),
    'cache'     => array(
        'class' => 'CFileCache',
        'behaviors' => array(
            'clear' => array(
                'class' => 'application.modules.engine.extensions.tagcache.TaggingCacheBehavior',
            ),
        ),
    ),
    'preload'   => array('log'),
    'component' => array(
        // параметры подключения к базе данных, подробнее http://www.yiiframework.ru/doc/guide/ru/database.overview
        'db' => require dirname(__FILE__) . '/../db.php',
    ),
    'rules' => array(
        '/engine/backend/modulesettings/<module:\w+>' => 'engine/backend/modulesettings',
    ),
    'module' => array(
        'components' => array(
            'bootstrap' => array(
                'class'          => 'application.modules.engine.extensions.booster.components.Bootstrap',
                'coreCss'        => true,
                'responsiveCss'  => true,
                'yiiCss'         => true,
                'jqueryCss'      => true,
                'enableJS'       => true,
                'fontAwesomeCss' => true,
            ),
        ),
    )
);