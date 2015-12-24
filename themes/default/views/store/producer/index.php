<?php
/**
 * @var CActiveDataProvider $brands
 */
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');

$this->breadcrumbs = [
    Yii::t("StoreModule.store", 'Catalog') => ['/store/product/index'],
    Yii::t('StoreModule.store', 'Producers list')
];
?>
<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t('StoreModule.store', 'Producers list'); ?></h2>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php $this->widget(
            'bootstrap.widgets.TbListView',
            [
                'dataProvider' => $brands,
                'itemView' => '_item',
                'summaryText' => '',
                'cssFile' => false,
            ]
        ); ?>
    </div>
</div>
