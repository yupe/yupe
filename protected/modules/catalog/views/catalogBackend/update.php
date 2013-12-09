<?php
    $this->breadcrumbs = array(        
        Yii::t('CatalogModule.catalog', 'Products') => array('/catalog/catalogBackend/index'),
        $model->name => array('/catalog/catalogBackend/view', 'id' => $model->id),
        Yii::t('CatalogModule.catalog', 'Edition'),
    );

    $this->pageTitle = Yii::t('CatalogModule.catalog', 'Products - edition');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Products administration'), 'url' => array('/catalog/catalogBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Add product'), 'url' => array('/catalog/catalogBackend/create')),
        array('label' => Yii::t('CatalogModule.catalog', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CatalogModule.catalog', 'Update product'), 'url' => array(
            '/catalog/catalogBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CatalogModule.catalog', 'Show product'), 'url' => array(
            '/catalog/catalogBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CatalogModule.catalog', 'Remove product'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/catalog/catalogBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('CatalogModule.catalog', 'Do you really want to remove product?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Update product'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
