<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog") => ['/store/product/index']];

?>


<div class="row">
    <div class="col-xs-12">
        <h2>
            <?php if($category):?>
                <?= Yii::t('StoreModule.store', 'Search in category "{category}"', ['{category}' => $category->name]); ?>
            <?php else:?>
                <?= Yii::t("StoreModule.store", "Search"); ?>
            <?php endif;?>
        </h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget'); ?>
</div>
<div class="row">
    <form id="store-filter" name="store-filter">
        <div class="col-sm-3">
            <?php if(null === $category):?>
                <div>
                    <?php $this->widget('application.modules.store.widgets.filters.CategoryFilterWidget'); ?>
                </div>
            <?php endif;?>
            <div>
                <?php $this->widget('application.modules.store.widgets.filters.ProducerFilterWidget', ['limit' => 30]); ?>
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
                        'itemView' => '_item',
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

