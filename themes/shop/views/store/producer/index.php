<?php
/**
 * @var CActiveDataProvider $brands
 */

$this->breadcrumbs = [
    Yii::t("StoreModule.store", 'Catalog') => ['/store/product/index'],
    Yii::t('StoreModule.store', 'Producers list')
];

?>
<div class="main__title grid">
    <h1 class="h2">
        <?= Yii::t('StoreModule.store', 'Producers list'); ?>
    </h1>
</div>

<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-2"></div>
        <div class="col grid-module-9">
            <?php $this->widget('zii.widgets.CListView', [
                'dataProvider' => $brands,
                'itemView' => '_item',
                'template' => '{items} {pager}',
                'itemsCssClass' => 'catalog__items',
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
            ]); ?>
        </div>
    </div>
</div>
