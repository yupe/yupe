<?php
/**
 *
 * Файл конфигурации модуля
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.install
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */
return array(
    'module'   => array(
        'class'  => 'application.modules.page.PageModule',
        // Указание здесь layout'a портит отображение на фронтенде:
        //'layout' => '//layouts/column2',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/pages/<slug>' => 'page/page/show',
    ),
);