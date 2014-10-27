<?php
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($this->module->getAssetsUrl() . '/js/store.js');
/* @var $category StoreCategory */

$this->breadcrumbs = array(Yii::t("StoreModule.catalog", "Каталог") => array('/store/catalog/index'));

?>

<div class="row">
    <div class="col-xs-12">
        <h2><?= Yii::t("StoreModule.catalog", "Каталог продукции"); ?></h2>
    </div>
</div>

<div class="row">
    <section class="catalog-filter col-sm-12">
        <form action="">
            <div class="input-group">
                <?php
                $this->widget(
                    'zii.widgets.jui.CJuiAutoComplete',
                    array(
                        'name' => 'q',
                        'value' => Yii::app()->getRequest()->getParam('q'),
                        'source' => $this->createUrl('/store/catalog/autocomplete'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                        ),
                        'htmlOptions' => array(
                            'class' => 'form-control',
                        ),
                    )
                );
                ?>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><?= Yii::t("StoreModule.catalog", "поиск"); ?> <i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
        </form>
    </section>
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

