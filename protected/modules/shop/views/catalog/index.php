<?php
/* @var $category Category */

$this->pageTitle   = $category ? ($category->meta_title ? : $category->name) : Yii::t('ShopModule.catalog', 'Products');
$this->breadcrumbs = array('Каталог' => array('/shop/catalog/index'));
$this->description = $category->meta_description;
$this->keywords    = $category->meta_keywords;

if ($category)
    $this->breadcrumbs = array_merge(
        $this->breadcrumbs,
        $category->getBreadcrumbs(true)
    );

?>

<div class="pagetitle">
    <div class="col-xs-12">
        <h2>Каталог продукции</h2>
    </div>
</div>
<div class="row-fluid">
    <div class="row-fluid">
        <section class="catalog-filter span12">
            <form action="">
                <div class="input-append">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name' => 'q',
                        'value' => $_GET['q'],
                        'source' => $this->createUrl('/shop/catalog/autocomplete'),
                        // additional javascript options for the autocomplete plugin
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                        ),
                        'htmlOptions' => array(
                            'class' => '',
                        ),
                    ));
                    ?>
                    <button type="submit" class="btn">поиск <i class="fa fa-search"></i></button>
                </div>
            </form>
        </section>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <h3><span>Категории</span></h3>

            <div class="category-tree">
                <?php
                $cat  = new ShopCategory();
                $tree = $cat->getMenuList(5);
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $tree,
                ));
                ?>
            </div>
        </div>
        <div class="span9">
            <section>
                <div class="sub-categories">
                    <?php $subCats = isset($category) ? $category->getMenuList() : null; ?>
                    <?php if ($subCats): ?>
                        <p>Подкатегории:</p>
                        <?php $this->widget('zii.widgets.CMenu', array('items' => $subCats)); ?>
                    <?php endif; ?>
                </div>
                <div class="grid">
                    <?php $this->widget('zii.widgets.CListView', array(
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
                        ),
                    )); ?>
                </div>
            </section>
        </div>
    </div>
</div>