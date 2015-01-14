<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.type', 'Типы товаров') => ['/store/typeBackend/index'],
    $model->name => ['/store/typeBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.type', 'Редактировать'),
];

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - редактировать');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.type', 'Добавить'), 'url' => ['/store/typeBackend/create']],
    ['label' => Yii::t('StoreModule.type', 'Тип товара') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.type', 'Редактировать'),
        'url' => [
            '/store/typeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.type', 'Просмотр'),
        'url' => [
            '/store/typeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.type', 'Удалить'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/typeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.type', 'Удалить этот тип товара?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'availableAttributes' => $availableAttributes]); ?>
