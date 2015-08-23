<?php
/**
 * Файл настроек для модуля
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.install
 * @since 0.1
 *
 */
return [
    'module'    => [
        'class'        => 'application.modules.blog.BlogModule',
        'panelWidgets' => [
            'application.modules.blog.widgets.PanelStatWidget' => [
                'limit' => 5
            ]
        ]
    ],
    'import'    => [],
    'component' => [
        'postManager' => [
            'class' => 'application.modules.blog.components.PostManager',
        ],
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\SitemapGeneratorListener', 'onGenerate']
                ]
            ]
        ]
    ],
    'rules'     => [
        '/post/<slug>.html'       => 'blog/post/view',
        '/posts/tag/<tag>'        => 'blog/post/tag',
        '/rss/blog/<blog>'        => 'blog/blogRss/feed',
        '/rss/posts/'             => 'blog/blogRss/feed',
        '/blogs/<slug>'           => 'blog/blog/view',
        '/blogs'                  => 'blog/blog/index',
        '/blog/join'              => 'blog/blog/join',
        '/blog/leave'             => 'blog/blog/leave',
        '/blog/<slug>/members'    => 'blog/blog/members',
        '/post/write'             => 'blog/publisher/write',
        '/post/my'                => 'blog/publisher/my',
        '/post/delete'            => 'blog/publisher/delete',
        '/post/update'            => 'blog/publisher/update',
        '/posts'                  => 'blog/post/index',
        '/posts/archive'          => 'blog/archive/index',
        '/posts/categories'       => 'blog/post/categories',
        '/posts/<slug>/'          => 'blog/post/blog',
        '/posts/category/<slug>'  => 'blog/post/category',

        '/post/imageUpload'       => 'blog/publisher/imageUpload',
        '/post/imageChoose'       => 'blog/publisher/imageChoose',
    ],
];
