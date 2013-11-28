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
return array(
    'module'   => array(
        'class' => 'application.modules.gallery.GalleryModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/albums' => 'gallery/gallery/list',
        '/albums/<id:\d+>' => 'gallery/gallery/show',
        '/albums/images/<id:\d+>' => 'gallery/gallery/image'
    ),
);