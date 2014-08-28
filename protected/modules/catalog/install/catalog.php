<?php
/**
 * Конфигурационный файл модуля
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog.install
 * @since 0.1
 *
 */
return array(
    'module'    => array(
        'class' => 'application.modules.catalog.CatalogModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/catalog'        => 'catalog/catalog/index',
        '/catalog/<name>' => 'catalog/catalog/show',
    ),
);
