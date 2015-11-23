<?php
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->breadcrumbs = [
    Yii::t("StoreModule.store", "Catalog") => ['/store/product/index'],
    'Избранные товары'
];
?>
<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-12">
            <div class="entry__title">
                <h1 class="h1">Избранные товары</h1>
            </div>
            <?php $this->widget(
                'zii.widgets.CListView', [
                    'dataProvider' => $dataProvider,
                    'itemView' => '//store/product/_item',
                    'template' => '
                        <div class="catalog-controls">
                            <div class="catalog-controls__col">{sorter}</div>
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
