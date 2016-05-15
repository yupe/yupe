<?php
/**
 * Класс миграций для модуля News
 *
 * @category YupeMigration
 * @package  yupe.modules.news.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
return [
    'module' => [
        'class' => 'application.modules.news.NewsModule',
    ],
    'import' => [],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\NewsSitemapGeneratorListener', 'onGenerate']
                ]
            ]
        ]
    ],
    'rules' => [
        '/news/' => 'news/news/index',
        '/news/categories' => 'news/newsCategory/index',
        '/news/<slug>' => 'news/newsCategory/view',
        ['news/news/view', 'pattern' => '/news/<slug>', 'urlSuffix' => '.html'],
    ],
];
