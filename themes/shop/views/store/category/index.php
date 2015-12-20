<?php
/**
 * @var $dataProvider CArrayDataProvider
 */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];
?>


<div class="row">
    <div class="col-sm-12">
        <?php $this->widget(
            'zii.widgets.CListView',
            [
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summaryText' => '',
                'cssFile' => false
            ]
        ); ?>
    </div>
</div>
