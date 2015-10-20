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
    [
        'target' => '.gallery-image',
        'lang' => 'ru',
        'config' => [
            'rel' => '.gallery-image',
        ],
    ]
); ?>

<?php $this->widget(
    'zii.widgets.CListView',
    [
        'dataProvider' => $dataProvider,
        'itemView' => '_image',
        'template' => "{items}\n{pager}",
        'summaryText' => '',
        'enableHistory' => true,
        'cssFile' => false,
        'itemsCssClass' => 'catalog__items gallery-thumbnails',
        'htmlOptions' => [
            'class' => 'catalog'
        ],
        'pagerCssClass' => 'catalog__pagination',
        'pager' => [
            'header' => '',
            'prevPageLabel' => '<i class="fa fa-long-arrow-left"></i>',
            'nextPageLabel' => '<i class="fa fa-long-arrow-right"></i>',
            'firstPageLabel' => false,
            'lastPageLabel' => false,
            'htmlOptions' => [
                'class' => 'pagination'
            ]
        ],
        'afterAjaxUpdate' => 'function(){$(".gallery-image").colorbox()}'
    ]
); ?>
