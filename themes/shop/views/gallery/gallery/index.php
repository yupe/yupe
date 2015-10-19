<?php
/**
 * Отображение для gallery/list:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $this GalleryController
 * @var $dataProvider CActiveDataProvider
 **/

$this->title = [Yii::t('GalleryModule.gallery', 'Image galleries'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('GalleryModule.gallery', 'Image galleries')];
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('GalleryModule.gallery', 'Image galleries'); ?></h1>
</div>
<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-9">
            <?php
            $this->widget(
                'zii.widgets.CListView',
                [
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
                    'template' => "{items}\n{pager}",
                    'summaryText' => '',
                    'enableHistory' => true,
                    'cssFile' => false,
                    'itemsCssClass' => 'catalog__items',
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
                    ]
                ]
            ); ?>
        </div>
    </div>
</div>
