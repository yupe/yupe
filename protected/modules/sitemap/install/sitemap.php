<?php

return [
    'module' => [
        'class' => 'application.modules.sitemap.SitemapModule',
    ],
    'import' => [],
    'component' => [],
    'rules' => [
        'sitemap.xml' => 'sitemap/sitemap/index',
        'sitemap/sitemap<number:\d+>.xml' => 'sitemap/sitemap/part',
    ],
];
