<?php
return [
    'module' => [
        'class' => 'application.modules.viewed.ViewedModule',
    ],
    'import' => [
        'application.modules.viewed.listeners.*',
        'application.modules.viewed.ViewedModule',
        'application.modules.viewed.components.ViewedService',
    ],
    'component' => [
        'viewed' => [
            'class' => 'application.modules.viewed.components.ViewedService'
        ],
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
            'events' => [
                'store.product.open' => [
                    ['\ViewedProductListener', 'onOpening']
                ],
            ]
        ]
    ],
];
