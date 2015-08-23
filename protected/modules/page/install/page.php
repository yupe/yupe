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
    'module'    => [
        'class' => 'application.modules.page.PageModule',
        // Указание здесь layout'a портит отображение на фронтенде:
        //'layout' => '//layouts/column2',
    ],
    'import'    => [],
    'component' => [
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\PageSitemapGeneratorListener', 'onGenerate']
                ]
            ]
        ]
    ],
    'rules'     => [
        '/pages/<slug>' => 'page/page/view',
    ],
];
