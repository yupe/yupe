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
        '/store' => 'store/catalog/index',
        '/store/search' => 'store/catalog/search',
        '/store/show/<name:[\w_\/-]+>' => 'store/catalog/show',
        '/store/<path:[\w_\/-]+>' => 'store/catalog/category',
        '/store/catalog/autocomplete' => 'store/catalog/autocomplete'
    ],
];
