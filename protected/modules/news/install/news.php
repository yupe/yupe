<?php
/**
 * Класс миграций для модуля News
 *
 * @category YupeMigration
 * @package  yupe.modules.news.install
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     https://yupe.ru
 **/
return [
    'module' => [
        'class' => 'application.modules.news.NewsModule',
    ],
    'import' => [
        'application.modules.news.events.*',
        'application.modules.news.listeners.*',
        'application.modules.news.helpers.*',
    ],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\NewsSitemapGeneratorListener', 'onGenerate']
                ],
                'news.after.save' => [
                    ['\NewsListener', 'onAfterSave']
                ],
                'news.after.delete' => [
                    ['\NewsListener', 'onAfterDelete']
                ],

            ]
        ]
    ],
    'rules' => [
        '/news/' => 'news/news/index',
        '/news/categories' => 'news/newsCategory/index',
        [
            'news/news/view',
            'pattern' => '/news/<slug>',
            'urlSuffix' => '.html'
        ],
        '/news/<slug>' => 'news/newsCategory/view',
        '/rss/news/' => 'news/newsRss/feed',
    ],
];
