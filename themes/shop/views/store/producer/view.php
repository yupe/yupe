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
<div class="main__title grid">
    <h1 class="h2">
        <?= Yii::t('StoreModule.store', 'The products of the manufacturer'); ?>
        &laquo;<?= CHtml::encode($brand->name) ?>&raquo;
    </h1>
</div>

<div class="main__recently-viewed-slider grid">
    <div class="col grid-module-3">
        <img src="<?= StoreImage::producer($brand, 100, 100);?>" alt="<?= CHtml::encode($brand->name); ?>">
    </div>
    <div class="col grid-module-8">
        <?= $brand->description ?>
    </div>
</div>
<p>&nbsp;</p>
<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-2"></div>
        <div class="col grid-module-9">
            <?php $this->widget(
                'zii.widgets.CListView', [
                    'dataProvider' => $products,
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
