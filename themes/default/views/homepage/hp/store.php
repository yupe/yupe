<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog") => ['/store/product/index']];

?>

<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t("StoreModule.store", "Product catalog"); ?></h2>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <section>
            <div class="grid">
                <?php $this->widget(
                    'bootstrap.widgets.TbListView',
                    [
                        'dataProvider' => $dataProvider,
                        'itemView' => '_product',
                        'summaryText' => '',
                        'enableHistory' => true,
                        'cssFile' => false,
                        'itemsCssClass' => 'row items',
                        'sortableAttributes' => [
                            'sku',
                            'name',
                            'price'
                        ],
                    ]
                ); ?>
            </div>
        </section>
    </div>
</div>

