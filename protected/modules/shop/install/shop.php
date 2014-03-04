<?php

return array(
    'module'   => array(
        'class' => 'application.modules.shop.ShopModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/catalog' => 'catalog/catalog/index',
        '/catalog/show/<name:[\w_\/-]+>' => 'catalog/catalog/show',
        '/catalog/<path:[\w_\/-]+>' => 'catalog/catalog/category',
    ),
);