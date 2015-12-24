<?php
/**
 * @var Producer $brand
 * @var CActiveDataProvider $products
 */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->title = $brand->meta_title ?: $brand->name;
$this->description = $brand->meta_description;
$this->keywords = $brand->meta_keywords;

$this->breadcrumbs = [
    Yii::t("StoreModule.store", 'Catalog') => ['/store/product/index'],
    Yii::t('StoreModule.store', 'Producers list') => ['/store/producer/index'],
    Yii::t('StoreModule.store', 'The products of the manufacturer') . ' "' . CHtml::encode($brand->name) . '"'
];

?>
<div class="row">
    <div class="col-xs-12">
        <h2>
            <?= Yii::t('StoreModule.store', 'The products of the manufacturer'); ?>
            &laquo;<?= CHtml::encode($brand->name) ?>&raquo;
        </h2>
    </div>
</div>

<div class="row">
    <div class="col-xs-4">
        <img src="<?= $brand->getImageUrl() ?>" alt="">
    </div>
    <div class="col-xs-8">
        <?= $brand->description ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-9 col-sm-offset-2">
        <section>
            <div class="grid">
                <?php $this->widget(
                    'bootstrap.widgets.TbListView',
                    [
                        'dataProvider' => $products,
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

