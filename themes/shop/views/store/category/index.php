<?php
/**
 * @var $dataProvider CArrayDataProvider
 */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];
?>

<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t("StoreModule.store", "Product catalog"); ?></h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget'); ?>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php $this->widget(
            'bootstrap.widgets.TbListView',
            [
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summaryText' => '',
                'cssFile' => false,
            ]
        ); ?>
    </div>
</div>
