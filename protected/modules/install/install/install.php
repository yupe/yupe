<?php
/**
 *
 * Файл конфигурации модуля
 *
 * @category YupeForms
 * @package  yupe.modules.install.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
return [
    'install' => true,
    'module'  => [
        'class' => 'application.modules.install.InstallModule',
    ],
    'preload' => ['bootstrap'],
    'rules'   => [
        // правила контроллера site
        '/' => '/install/default/index'
    ],
];
