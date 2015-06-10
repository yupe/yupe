<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];

?>

<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t("StoreModule.product", "Product catalog"); ?></h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget'); ?>
</div>
<div class="row">
    <form id="store-filter" name="store-filter">
        <div class="col-sm-3">
            <div>
                <?php $this->widget('application.modules.store.widgets.filters.CategoryFilterWidget'); ?>
            </div>
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
                        'itemView' => '_view',
                        'summaryText' => '',
                        'enableHistory' => true,
                        'cssFile' => false,
                        'pager' => [
                            'cssFile' => false,
                            'htmlOptions' => ['class' => 'pagination'],
                            'header' => '',
                            'firstPageLabel' => '&lt;&lt;',
                            'lastPageLabel' => '&gt;&gt;',
                            'nextPageLabel' => '&gt;',
                            'prevPageLabel' => '&lt;',
                        ],
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

