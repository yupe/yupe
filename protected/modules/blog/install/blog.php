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
    'module'   => array(
        'class' => 'application.modules.blog.BlogModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/post/<slug>.html' => 'blog/post/show',
        '/posts/tag/<tag>'  => 'blog/post/list',
        '/blogs/<slug>'     => 'blog/blog/show',
        '/blogs'            => 'blog/blog/index',
        '/posts'            => 'blog/post/index',
        '/posts/<slug>/'    => 'blog/post/blog'
    ),
);