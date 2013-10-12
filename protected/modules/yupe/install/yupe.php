<?php

/**
 * Файл конфигурации модуля
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

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
    'preload'   => array('log'),
    'component' => array(
        // Массив компонентов, которые требует данный модуль
    ),
    'rules' => array(
        '/backend/modulesettings/<module:\w+>' => 'yupe/backend/modulesettings',
    ),
    'module' => array(
        'components' => array(
            'bootstrap' => array(
                'class'          => 'vendor.clevertech.yii-booster.src.components.Bootstrap',
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