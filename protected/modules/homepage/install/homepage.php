<?php
/**
 * Файл конфигурации модуля
 *
 * @category YupeController
 * @package  yupe.modules.homepage.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
return [
    'module'    => [
        'class' => 'application.modules.homepage.HomepageModule',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/' => '/homepage/hp/index',
    ],
];
