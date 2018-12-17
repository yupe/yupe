<?php
/**
 * Конфигурационный файл модуля
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.category.install
 * @since 0.1
 *
 */
return [
    'module' => [
        'class' => 'application.modules.category.CategoryModule',
    ],
    'import' => [
        'application.modules.category.models.*',
        'application.modules.category.events.*',
        'application.modules.category.listeners.*',
        'application.modules.category.helpers.*',
        'application.modules.category.components.*',
    ],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'category.after.save' => [
                    ['\CategoryListener', 'onAfterSave']
                ],
                'category.after.delete' => [
                    ['\CategoryListener', 'onAfterDelete']
                ],

            ]
        ],
        'categoriesRepository' => [
            'class' => 'application.modules.category.components.CategoryRepository'
        ],
    ],
    'rules' => [],
];
