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
        '/story/<title>' => 'news/news/show',
    ),
);