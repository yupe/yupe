<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Products') => ['/store/productBackend/index'],
    $model->name => ['/store/productBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.store', 'Edition'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Products - edition');

$this->menu = [
    ['label' => Yii::t('StoreModule.store', 'Product') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Update product'),
        'url' => [
            '/store/productBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'Show product'),
        'url' => [
            '/store/productBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Remove product'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/productBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove the product?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Update product'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
