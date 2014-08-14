<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.product', 'Products') => array('/store/productBackend/index'),
    $model->name => array('/store/productBackend/view', 'id' => $model->id),
    Yii::t('StoreModule.product', 'Edition'),
);

$this->pageTitle = Yii::t('StoreModule.product', 'Products - edition');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.product', 'Products administration'), 'url' => array('/store/productBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.product', 'Add a product'), 'url' => array('/store/productBackend/create')),
    array('label' => Yii::t('StoreModule.product', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('StoreModule.product', 'Update product'),
        'url' => array(
            '/store/productBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('StoreModule.product', 'Show product'),
        'url' => array(
            '/store/productBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('StoreModule.product', 'Remove product'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/productBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.product', 'Do you really want to remove the product?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.product', 'Update product'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
