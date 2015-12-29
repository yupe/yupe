<?php
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
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

<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t('StoreModule.store', 'Products in category "{category}"', ['{category}' => CHtml::encode($category->name)]); ?></h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget'); ?>
</div>
<div class="row">
    <form id="store-filter" name="store-filter" method="get">
        <div class="col-sm-3">
            <div>
                <?php $this->widget('application.modules.store.widgets.filters.ProducerFilterWidget'); ?>
            </div>
            <div>
                <?php $this->widget('application.modules.store.widgets.filters.FilterBlockWidget', ['attributes' => '*']); ?>
            </div>
        </div>
    </form>
    <div class="col-sm-9">
        <section>

            <div class="grid">
                <?php $this->widget(
                    'bootstrap.widgets.TbListView',
                    [
                        'dataProvider' => $dataProvider,
                        'itemView' => '//store/product/_item',
                        'summaryText' => '',
                        'enableHistory' => true,
                        'cssFile' => false,
                        'itemsCssClass' => 'row items',
                        'sortableAttributes' => [
                            'sku',
                            'name',
                            'price',
                            'update_time'
                        ],
                    ]
                ); ?>
            </div>
        </section>
    </div>
</div>

