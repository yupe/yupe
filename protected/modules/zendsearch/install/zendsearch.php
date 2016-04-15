<?php

return [
    'module'    => [
        'class'        => 'application.modules.zendsearch.ZendSearchModule',
        // Указание здесь layout'a портит отображение на фронтенде:
        //'layout' => '//layouts/column2',
        'searchModels' => [
            'News' => [
                'path'        => 'application.modules.news.models.News',
                'module'      => 'news',
                'titleColumn' => 'title',
                'linkColumn'  => 'slug',
                'linkPattern' => '/news/news/view?title={slug}',
                'textColumns' => 'full_text,short_text,keywords,description',
            ],
            'Page' => [
                'module'      => 'page',
                'path'        => 'application.modules.page.models.Page',
                'titleColumn' => 'title',
                'linkColumn'  => 'slug',
                'linkPattern' => '/page/page/view?slug={slug}',
                'textColumns' => 'body,title_short,keywords,description',
            ],
        ],
    ],
    'import'    => [
        'application.modules.zendsearch.models.*',
    ],
    'component' => [],
    'rules'     => [
        '/search' => 'zendsearch/search/search',
    ],
];
