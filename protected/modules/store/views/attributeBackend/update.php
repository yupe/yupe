<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Атрибуты') => ['/store/attributeBackend/index'],
    $model->name => ['/store/attributeBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.store', 'Редактировать'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Атрибуты - редактировать');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить'), 'url' => ['/store/attributeBackend/create']],
    ['label' => Yii::t('StoreModule.store', 'Атрибут') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Редактировать'),
        'url' => [
            '/store/attributeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'Просмотр'),
        'url' => [
            '/store/attributeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Удалить'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/attributeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
