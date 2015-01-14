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
    [
        'target' => '.gallery-image',
        'config' => [ // тут конфиги плагина, подробнее http://www.jacklmoore.com/colorbox
        ],
    ]
);
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery.views.assets'));
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/gallery.css');
?>


<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider'  => $dataProvider,
        'itemView'      => '_image',
        'template'      => "{items}\n{pager}",
        'itemsCssClass' => 'row gallery-thumbnails thumbnails',
        'itemsTagName'  => 'div'
    ]
); ?>
