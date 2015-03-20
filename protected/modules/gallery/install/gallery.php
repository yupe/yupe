<?php
/**
 * Файл конфигурации модуля
 *
 * @category YupeMigration
 * @package  yupe.modules.gallery.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
return [
    'module'    => [
        'class' => 'application.modules.gallery.GalleryModule',
    ],
    'import'    => [],
    'component' => [],
    'rules'     => [
        '/albums'                 => '/gallery/gallery/index',
        '/albums/<id:\d+>'        => '/gallery/gallery/view',
        '/albums/images/<id:\d+>' => '/gallery/gallery/image'
    ],
];
