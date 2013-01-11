<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('CatalogModule.catalog', 'Товары') => array('/admin/catalog'),
        Yii::t('CatalogModule.catalog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('CatalogModule.catalog', 'Товары - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Управление товарами'), 'url' => array('/admin/catalog')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Добавить товар'), 'url' => array('/admin/catalog/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Товары'); ?>
        <small><?php echo Yii::t('CatalogModule.catalog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>