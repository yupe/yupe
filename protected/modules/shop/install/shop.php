<?php

return array(
    'module' => array(
        'class' => 'application.modules.shop.ShopModule',
    ),
    'import' => array(),
    'component' => array(
        'shoppingCart' =>
            array(
                'class' => 'application.modules.shop.extensions.shopping-cart.EShoppingCart',
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
    ),
);