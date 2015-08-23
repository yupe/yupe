<?php

return [
    'module' => [
        'class' => 'application.modules.store.StoreModule',
    ],
    'import' => [
        'application.modules.store.models.*',
    ],
    'component' => [
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
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
            'class'   => 'CHttpSession',
            'timeout' => 86400,
            'cookieParams' => ['httponly' => true]
        ]
    ],
    'rules' => [
        '/store' => 'store/catalog/index',
        '/store/search' => 'store/catalog/search',
        '/store/show/<name:[\w_\/-]+>' => 'store/catalog/product',
        '/store/<path:[\w_\/-]+>' => 'store/catalog/category',
        '/store/catalog/autocomplete' => 'store/catalog/autocomplete'
    ],
];
