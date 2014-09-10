<?php

return array(
    'module' => array(
        'class' => 'application.modules.cart.CartModule',
    ),
    'import' => array(
        'application.modules.cart.extensions.shopping-cart.*',
        'application.modules.cart.models.*',
    ),
    'component' => array(
        'cart' => array(
            'class' => 'application.modules.cart.extensions.shopping-cart.EShoppingCart',
        ),
    ),
    'rules' => array(
        '/cart' => 'cart/cart/index',
        '/cart/<action:\w+>' => 'cart/cart/<action>',
        '/cart/<action:\w+>/<id:\w+>' => 'cart/cart/<action>',
    ),
);
