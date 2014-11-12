<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = array(Yii::t("StoreModule.catalog", "Каталог") => array('/store/catalog/index'));

?>


<div class="row">
    <div class="col-xs-12">
        <h2>
            <?php if($category):?>
                <?= Yii::t("StoreModule.catalog", "Поиск в категории '{category}'", ['{category}' => $category->name]); ?>
            <?php else:?>
                <?= Yii::t("StoreModule.catalog", "Поиск"); ?>
            <?php endif;?>
        </h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget', ['query' => $searchForm->q, 'category' => $searchForm->category]); ?>
</div>
<div class="row">
    <div class="col-sm-3">
        <h3>
            <span><?= Yii::t("StoreModule.catalog", "Категории"); ?></span>
        </h3>
        <div class="category-tree">
            <?php
            $this->widget('application.modules.store.widgets.CategoryWidget');
            ?>
        </div>
    </div>
    <div class="col-sm-9">
        <section>
            <div class="grid">
                <?php $this->widget(
                    'zii.widgets.CListView',
                    array(
                        'dataProvider' => $dataProvider,
                        'itemView' => '_view',
                        'summaryText' => '',
                        'enableHistory' => true,
                        'cssFile' => false,
                        'pager' => array(
                            'cssFile' => false,
                            'htmlOptions' => array('class' => 'pagination'),
                            'header' => '',
                            'firstPageLabel' => '&lt;&lt;',
                            'lastPageLabel' => '&gt;&gt;',
                            'nextPageLabel' => '&gt;',
                            'prevPageLabel' => '&lt;',
                        ),
                        'sortableAttributes' => array(
                            'sku',
                            'name',
                            'price'
                        ),
                    )
                ); ?>
            </div>
        </section>
    </div>
</div>

