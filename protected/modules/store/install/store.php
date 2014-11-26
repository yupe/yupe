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
    ],
    'rules' => [
        '/catalog' => 'store/catalog/index',
        '/catalog/search' => 'store/catalog/search',
        '/catalog/show/<name:[\w_\/-]+>' => 'store/catalog/show',
        '/catalog/<path:[\w_\/-]+>' => 'store/catalog/category',
        '/store/catalog/autocomplete' => 'store/catalog/autocomplete'
    ],
];
