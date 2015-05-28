<?php

return [
    'module' => [
        'class' => 'application.modules.store.StoreModule',
    ],
    'import' => [
        'application.modules.store.models.*',
    ],
    'component' => [
        'money' => [
            'class' => 'application.modules.store.components.Money',
        ],
        'productRepository' => [
            'class' => 'application.modules.store.components.ProductRepository'
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
        '/store/show/<name:[\w_\/-]+>' => 'store/catalog/show',
        '/store/<path:[\w_\/-]+>' => 'store/catalog/category',
        '/store/catalog/autocomplete' => 'store/catalog/autocomplete'
    ],
];
