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
$url = Yii::app()->getAssetManager()->getPublishedUrl(
    Yii::app()->theme->basePath . '/web/'
);

Yii::app()->getClientScript()->registerScriptFile($url . '/js/masonry.min.js', CClientScript::POS_END);
Yii::app()->getClientScript()->registerScriptFile($url . '/js/imagesloaded.min.js', CClientScript::POS_END);



Yii::app()->clientScript->registerScript(
    $this->getId(),
    'var $container = jQuery(".gallery-thumbnails");
    $container.imagesLoaded(function() {
        $container.masonry({
            itemSelector: ".gallery-thumbnail",
            gutter: 10
        });
    });'
);

$this->widget(
    'gallery.extensions.colorbox.ColorBox',
    array(
        'target' => '.gallery-image',
        'lang' => 'ru',
        'config' => array(
            'rel' => '.gallery-image',
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