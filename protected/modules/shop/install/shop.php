<?php

return array(
    'module' => array(
        'class' => 'application.modules.shop.ShopModule',
    ),
    'import' => array(),
    'component' => array(
        'shoppingCart' => array(
            'class' => 'application.modules.shop.extensions.shopping-cart.EShoppingCart',
        ),
        'money' => array(
            'class' => 'application.modules.shop.components.Money',
        ),
        'request' => array(
            'noCsrfValidationRoutes' => array(
                'shop/payment/process',
            ),
        ),
    ),
    'rules' => array(
        '/catalog' => 'shop/catalog/index',
        '/catalog/show/<name:[\w_\/-]+>' => 'shop/catalog/show',
        '/catalog/<path:[\w_\/-]+>' => 'shop/catalog/category',
        '/shop/catalog/autocomplete' => 'shop/catalog/autocomplete',
        '/cart' => 'shop/cart/index',
        '/cart/<action:\w+>' => 'shop/cart/<action>',
        '/cart/<action:\w+>/<id:\w+>' => 'shop/cart/<action>',
        '/order/<url:\w+>' => 'shop/order/view',
        '/shop/order/<action:\w+>' => 'shop/order/<action>',
        '/shop/account' => 'shop/user/index',
        '/shop/account/<action:\w+>' => 'shop/user/<action>',
        '/shop/payment/process/<id:\w+>' => 'shop/payment/process',
    ),
);