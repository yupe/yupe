<?php
/**
 * Класс миграций для модуля Metrika
 *
 * @category YupeMigration
 * @package  yupe.modules.metrika.install
 * @author   apexwire <apexwire@amylabs.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
return array(
    'module'   => array(
        'class' => 'application.modules.metrika.MetrikaModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/metrika/' => 'metrika/metrika/index',
    ),
);