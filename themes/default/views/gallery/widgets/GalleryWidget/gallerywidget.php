<?php
/**
 * Отображение для GalleryWidget/gallerywidget:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$url = Yii::app()->getTheme()->getAssetsUrl();

Yii::app()->getClientScript()->registerScriptFile($url . '/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile($url . '/js/imagesloaded.min.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript(
    $this->getId(),
    'var $container = jQuery(".gallery-thumbnails");
    $container.imagesLoaded(function () {
        $container.masonry({
            itemSelector: ".gallery-thumbnail",
            gutter: 10
        });
    });'
);

$this->widget(
    'gallery.extensions.colorbox.ColorBox',
    [
        'target' => '.gallery-image',
        'lang'   => 'ru',
        'config' => [
            'rel' => '.gallery-image',
        ],
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider'  => $dataProvider,
        'itemView'      => '_image',
        'template'      => "{items}\n{pager}",
        'itemsCssClass' => 'row gallery-thumbnails thumbnails',
        'itemsTagName'  => 'ul',
        'afterAjaxUpdate' => '$.fn.colorbox.init()'
    ]
); ?>
