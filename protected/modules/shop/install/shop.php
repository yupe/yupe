<?php
/**
 *
 * Файл конфигурации модуля shop
 *
 * @author amarin <antonaryo@yandex.ru>
 * @copyright 2014 Anton Marin
 * @package yupe.modules.shop.install
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.7
 *
 */
return array(
    'module'   => array(
        'class'  => 'application.modules.shop.ShopModule',
    ),
    'import'    => array(
        'application.modules.shop.models.*',
    ),
    'component' => array(),
    'rules' => array(
        '/shop' => 'shop/shop/index',
        '/shop/category/<cat>' => 'shop/shop/index/category/<cat>',
        '/shop/<name>' => 'shop/shop/show',
        '/shop/cart/<action>/*' => 'shop/cart/<action>',
        '/shop/order/<action>/*' => 'shop/order/<action>',
    )
);