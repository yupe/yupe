<?php

return [
    'module' => [
        'class' => 'application.modules.store.StoreModule',
    ],
    'import' => [
        'application.modules.store.models.*',
    ],
    'component' => [
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'sitemap.before.generate' => [
                    ['\StoreSitemapGeneratorListener', 'onGenerate']
                ]
            ]
        ],
        'money' => [
            'class' => 'application.modules.store.components.Money',
        ],
        'productRepository' => [
            'class' => 'application.modules.store.components.ProductRepository'
        ],
        'attributesFilter' => [
            'class' => 'application.modules.store.components.AttributeFilter'
        ],
        'session' => [
            'class' => 'CHttpSession',
            'timeout' => 86400,
            'cookieParams' => ['httponly' => true]
        ]
    ],
    'rules' => [
        '/store' => 'store/product/index',
        '/store/search' => 'store/product/search',
        '/store/show/<name:[\w_\/-]+>' => 'store/product/view',
        '/store/categories' => 'store/category/index',
        '/store/brand/<slug:[\w_\/-]+>' => 'store/producer/view',
        '/store/brands' => 'store/producer/index',
        '/store/<path:[\w_\/-]+>' => 'store/category/view'
    ],
];
