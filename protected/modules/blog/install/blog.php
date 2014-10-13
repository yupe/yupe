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
return array(
    'module'    => array(
        'class'        => 'application.modules.blog.BlogModule',
        'panelWidgets' => array(
            'application.modules.blog.widgets.PanelStatWidget' => array(
                'limit' => 5
            )
        )
    ),
    'import'    => array(),
    'component' => array(
        'postManager' => array(
            'class' => 'application.modules.blog.components.PostManager',
        ),
    ),
    'rules'     => array(
        '/post/<slug>.html'       => 'blog/post/show',
        '/posts/tag/<tag>'        => 'blog/post/list',
        '/rss/blog/<blog>'        => 'blog/blogRss/feed',
        '/rss/posts/'             => 'blog/blogRss/feed',
        '/blogs/<slug>'           => 'blog/blog/show',
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
        '/posts/category/<alias>' => 'blog/post/category'
    ),
);
