<?php
return array(
    'module'   => array(
        'class' => 'application.modules.blog.BlogModule',
    ),
    'import'    => array(
        'application.modules.blog.models.*',
    ),
    'component' => array(),
    'rules'     => array(
        '/post/<slug>.html' => 'blog/post/show',
        '/posts/tag/<tag>'  => 'blog/post/list',
        '/blog/<slug>'      => 'blog/blog/show',
        '/blogs'            => 'blog/blog/index',
    ),
);