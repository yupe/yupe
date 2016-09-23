<?php

return [
    'module' => [
        'class' => 'application.modules.zendsearch.ZendSearchModule',
        'searchModels' => [
            'News' => [
                'path' => 'application.modules.news.models.News',
                'module' => 'news',
                'titleColumn' => 'title',
                'linkColumn' => 'slug',
                'linkPattern' => '/news/news/view?slug={slug}',
                'textColumns' => 'full_text,short_text,keywords,description,slug',
                'criteria' => [
                    'condition' => 'status = :status',
                    'params' => [
                        ':status' => 1
                    ],
                ],
            ],
            'Page' => [
                'path' => 'application.modules.page.models.Page',
                'module' => 'page',
                'titleColumn' => 'title',
                'linkColumn' => 'slug',
                'linkPattern' => '/page/page/view?slug={slug}',
                'textColumns' => 'body,title_short,keywords,description,slug',
                'criteria' => [
                    'condition' => 'status = :status',
                    'params' => [
                        ':status' => 1
                    ],
                ],
            ],
            'Blog' => [
                'path' => 'application.modules.blog.models.Blog',
                'module' => 'blog',
                'titleColumn' => 'name',
                'linkColumn' => 'slug',
                'linkPattern' => '/blog/blog/view?slug={slug}',
                'textColumns' => 'name,description,slug',
                'criteria' => [
                    'condition' => 'status = :status',
                    'params' => [
                        ':status' => 1
                    ],
                ],
            ],
            'Post' => [
                'path' => 'application.modules.blog.models.Post',
                'module' => 'blog',
                'titleColumn' => 'title',
                'linkColumn' => 'slug',
                'linkPattern' => '/blog/post/view?slug={slug}',
                'textColumns' => 'title,quote,content,slug',
                'criteria' => [
                    'condition' => 'status = :status',
                    'params' => [
                        ':status' => 1
                    ],
                ],
            ],
            'Product' => [
                'path' => 'application.modules.store.models.Product',
                'module' => 'store',
                'titleColumn' => 'name',
                'linkColumn' => 'slug',
                'linkPattern' => '/store/product/view?slug={slug}',
                'textColumns' => 'name,sku,slug,description,meta_title,meta_description,meta_keywords',
                'criteria' => [
                    'condition' => 'status = :status',
                    'params' => [
                        ':status' => 1
                    ],
                ],
            ],
        ],
    ],
    'import' => [
        'application.modules.zendsearch.models.*',
    ],
    'component' => [],
    'rules' => [
        '/search' => 'zendsearch/search/search',
    ],
];
