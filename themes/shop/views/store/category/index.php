<?php
/**
 * @var $dataProvider CArrayDataProvider
 */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];
?>
<div class="main__title grid">
    <h1 class="h2">
        <?= Yii::t('StoreModule.store', 'Categories'); ?>
    </h1>
</div>

<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-12">
            <?php $this->widget('zii.widgets.CListView', [
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'template' => '{items} {pager}',
                'itemsCssClass' => 'catalog__category-items',
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
