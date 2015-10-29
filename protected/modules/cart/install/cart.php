<?php

return [
    'module' => [
        'class' => 'application.modules.cart.CartModule',
    ],
    'import' => [
        'application.modules.cart.components.shopping-cart.*',
        'application.modules.cart.models.CartProduct',
    ],
    'component' => [
        'cart' => [
            'class' => 'application.modules.cart.components.shopping-cart.EShoppingCart',
        ],
    ],
    'rules' => [
        '/cart' => 'cart/cart/index',
        '/cart/<action:\w+>' => 'cart/cart/<action>',
        '/cart/<action:\w+>/<id:\w+>' => 'cart/cart/<action>',
    ],
];
