<?php
/**
 *
 * Файл конфигурации модуля
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.install
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */
return [
    'module' => [
        'class' => 'application.modules.page.PageModule'
    ],
    'import' => [
        'application.modules.page.events.*',
        'application.modules.page.listeners.*',
        'application.modules.page.models.*',
    ],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\PageSitemapGeneratorListener', 'onGenerate'],
                ],
                'page.after.save' => [
                    ['\PageListener', 'onAfterSave']
                ],
            ],
        ],
    ],
    'behaviors' => [
        'page' => ['class' => 'application.modules.page.behaviors.PageBehavior']
    ],
];
