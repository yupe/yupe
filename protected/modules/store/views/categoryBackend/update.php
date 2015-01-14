<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Categories') => ['/store/categoryBackend/index'],
    $model->name => ['/store/categoryBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.store', 'Change'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Categories - edit');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Category manage'), 'url' => ['/store/categoryBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => ['/store/categoryBackend/create']],
    ['label' => Yii::t('StoreModule.store', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Change category'),
        'url' => [
            '/store/categoryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'View category'),
        'url' => [
            '/store/categoryBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Remove category'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/categoryBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove category?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Change category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
