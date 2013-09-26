<?php
return array(
    'module'   => array(
        'class' => 'application.modules.news.NewsModule',
    ),
    'import'    => array(
        'application.modules.news.models.*',
    ),
    'component' => array(),
    'rules'     => array(
        '/news/' => 'news/news/index',
        '/news/<alias>' => 'news/news/show',
    ),
);