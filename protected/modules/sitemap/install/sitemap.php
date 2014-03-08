<?php

return array(
    'module'   => array(
        'class' => 'application.modules.sitemap.SitemapModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        'sitemap.xml' => 'sitemap/sitemap/index',
    ),
);