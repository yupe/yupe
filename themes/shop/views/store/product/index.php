<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];

?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t("StoreModule.store", "Product catalog"); ?></h1>
</div>

<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-3">
            <div class="catalog-filter">
                <form id="store-filter" name="store-filter" method="get">
                    <?php $this->widget('application.modules.store.widgets.filters.PriceFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.CategoryFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.ProducerFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.FilterBlockWidget', ['attributes' => '*']); ?>
                </form>
            </div>
        </div>
        <div class="col grid-module-9">
            <div class="catalog-controls">
                <div class="catalog-controls__col">
                    <div class="sorter">
                        <div class="sorter__description">Сортировать:</div><a href="javascript:void(0);" class="asc">по популярности</a><a href="javascript:void(0);" class="desc">по цене</a><a href="javascript:void(0);">по названию</a>
                    </div>
                </div>
                <div class="catalog-controls__col catalog-controls__col_right">
                    <div class="view-switch">
                        <div class="view-switch__caption"></div>
                        <div class="view-switch__toggle">
                            <div class="switch">
                                <div class="switch__item">
                                    <div class="switch-item">
                                        <input type="radio" id="view-switch-list" name="view-switch" value="list" class="switch-item__input">
                                        <label for="view-switch-list" class="switch-item__label"><i class="fa fa-th-list fa-fw"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="switch__item">
                                    <div class="switch-item">
                                        <input type="radio" id="view-switch-grid" name="view-switch" value="grid" checked class="switch-item__input">
                                        <label for="view-switch-grid" class="switch-item__label"><i class="fa fa-th fa-fw"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->widget(
                'zii.widgets.CListView',
                [
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
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