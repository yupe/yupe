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
$this->widget(
    'gallery.extensions.colorbox.ColorBox',
    array(
        'target' => '.gallery-image',
        'lang' => 'ru', // если не установить, то будет изспользован Yii::app()->language
        'config' => array(
             'rel' => '.gallery-image'// тут конфиги плагина, подробнее http://www.jacklmoore.com/colorbox
        ),
    )
); ?>

<?php
    $this->widget(
        'bootstrap.widgets.TbListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_image',
        )
    );
?>
