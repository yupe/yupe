<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.attribute', 'Типы товаров') => ['index'],
    $model->name,
];

$this->pageTitle = Yii::t('StoreModule.attribute', 'Типы товаров - просмотр');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.attribute', 'Управление'), 'url' => ['/store/typeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.attribute', 'Добавить'), 'url' => ['/store/typeBackend/create']],
    ['label' => Yii::t('StoreModule.attribute', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.attribute', 'Редактировать'),
        'url' => [
            '/store/typeBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.attribute', 'Просмотр'),
        'url' => [
            '/store/typeBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.attribute', 'Удалить'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/typeBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.attribute', 'Do you really want to remove attribute?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.attribute', 'Просмотр типа'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]
); ?>
