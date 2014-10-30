<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/js/store.js');
/* @var $category StoreCategory */

$this->pageTitle =  $category->getMetaTile();
$this->description = $category->getMetaDescription();
$this->keywords =  $category->getMetaKeywords();

$this->breadcrumbs = array(Yii::t("StoreModule.catalog", "Каталог") => array('/store/catalog/index'));

$this->breadcrumbs = array_merge(
    $this->breadcrumbs,
    $category->getBreadcrumbs(true)
);

?>

<div class="row">
    <div class="col-xs-12">
        <h2><?php echo Yii::t("StoreModule.catalog", "Товары в категории '{category}'", ['{category}' => CHtml::encode($category->name)]); ?></h2>
    </div>
</div>

<div class="row">
    <?php $this->widget('application.modules.store.widgets.SearchProductWidget', ['category' => $category->id]); ?>
</div>
<div class="row">
    <div class="col-sm-3">
        <h3>
            <span><?php echo Yii::t("StoreModule.catalog", "Категории"); ?></span>
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

