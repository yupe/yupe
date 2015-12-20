<?php
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');
/* @var $category StoreCategory */

$this->title =  $category->getMetaTile();
$this->metaDescription = $category->getMetaDescription();
$this->metaKeywords =  $category->getMetaKeywords();

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog") => ['/store/product/index']];

$this->breadcrumbs = array_merge(
    $this->breadcrumbs,
    $category->getBreadcrumbs(true)
);

?>
<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-3">
            <?php if($this->beginCache('store::filters', ['duration' => $this->yupe->coreCacheTime])):?>
            <div class="catalog-filter">
                <form id="store-filter" name="store-filter" method="get">
                    <?php $this->widget('application.modules.store.widgets.filters.PriceFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.CategoryFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.ProducerFilterWidget', ['limit' => 30]); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.FilterBlockWidget', ['attributes' => '*']); ?>
                </form>
            </div>
                <?php  $this->endCache();?>
            <?php endif;?>
        </div>
        <div class="col grid-module-9">
            <div class="entry__title">
                <h1 class="h1"><?= Yii::t('StoreModule.store', 'Products in category "{category}"', ['{category}' => CHtml::encode($category->name)]); ?></h1>
            </div>
            <?php $this->widget(
                'zii.widgets.CListView', [
                    'dataProvider' => $dataProvider,
                    'itemView' => '//store/product/_item',
                    'template' => '
                        <div class="catalog-controls">
                            <div class="catalog-controls__col">{sorter}</div>
                        </div>
                        {items}
                        {pager}
                    ',
                    'summaryText' => '',
                    'enableHistory' => true,
                    'cssFile' => false,
                    'itemsCssClass' => 'catalog__items',
                    'sortableAttributes' => [
                        'sku',
                        'name',
                        'price',
                        'update_time'
                    ],
                    'sorterHeader' => '<div class="sorter__description">Сортировать:</div>',
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
