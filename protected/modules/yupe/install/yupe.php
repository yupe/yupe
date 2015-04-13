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

return [
    'import'    => [
        'application.modules.yupe.components.validators.*',
        'application.modules.yupe.components.exceptions.*',
        'application.modules.yupe.extensions.tagcache.*',
        'application.modules.yupe.helpers.*',
        'application.modules.yupe.models.*',
    ],
    'preload'   => ['log'],
    'component' => [
        // Массив компонентов, которые требует данный модуль
        // настройки кэширования, подробнее http://www.yiiframework.ru/doc/guide/ru/caching.overview
        // конфигурирование memcache в юпи http://yupe.ru/docs/memcached.html
        'cache' => [
            'class'     => 'CFileCache',
            'behaviors' => [
                'clear' => [
                    'class' => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
                ],
            ],
        ],
    ],
    'rules'     => [],
    'module'    => [
        'components'    => [
            'bootstrap' => [
                'class'            => 'vendor.clevertech.yii-booster.src.components.Booster',
                'coreCss'          => true,
                'responsiveCss'    => true,
                'yiiCss'           => true,
                'jqueryCss'        => true,
                'enableJS'         => true,
                'fontAwesomeCss'   => true,
                'enableNotifierJS' => false,
            ],
        ],
        'visualEditors' => [
            'redactor' => [
                'class' => 'yupe\widgets\editors\Redactor',
            ],
            'ckeditor' => [
                'class' => 'yupe\widgets\editors\CKEditor',
            ],
            'textarea' => [
                'class' => 'yupe\widgets\editors\Textarea',
            ],
        ],
    ]
    ,
    'commandMap' => [
        'yupe' => [
            'class' => 'application.modules.yupe.commands.YupeCommand',
        ],
        'testenv' => [
            'class' => 'application.modules.yupe.commands.TestEnvCommand'
        ]
    ]
];
