<?php

return [
    'module' => [
        'class' => 'application.modules.sitemap.SitemapModule'
    ],
    'import' => [
        'application.modules.blog.listeners.SitemapGeneratorListener',
        'application.modules.news.listeners.NewsSitemapGeneratorListener',
        'application.modules.page.listeners.PageSitemapGeneratorListener',
        'application.modules.store.listeners.StoreSitemapGeneratorListener'
    ],
    'component' => [
        'sitemapGenerator' => [
            'class' => 'application.modules.sitemap.components.SitemapGenerator'
        ]
    ],
    'rules' => [
        'sitemap.xml' => 'sitemap/sitemap/index'
    ]
];
