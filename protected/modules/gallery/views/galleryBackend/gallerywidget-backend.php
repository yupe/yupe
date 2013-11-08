<?php
/**
 * Отображение для GalleryWidget/gallerywidget:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->widget(
    'gallery.extensions.colorbox.ColorBox',
    array(
        'target' => '.gallery-image',
        'config' => array(// тут конфиги плагина, подробнее http://www.jacklmoore.com/colorbox
        ),
    )
); ?>


<?php $this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $dataProvider,
        'itemView' => '_image',
        'template' => "{items}\n{pager}",
        'itemsCssClass' => 'gallery-thumbnails thumbnails',
        'itemsTagName' => 'ul'
    )
); ?>