<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.producer', 'Производители') => ['/store/producerBackend/index'],
    $model->name_short => ['/store/producerBackend/view', 'id' => $model->id],
    Yii::t('StoreModule.producer', 'Редактирование'),
];

$this->pageTitle = Yii::t('StoreModule.producer', 'Производители - редактирование');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Управление производителями'), 'url' => ['/store/producerBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Добавить производителя'), 'url' => ['/store/producerBackend/create']],
    ['label' => Yii::t('StoreModule.producer', 'Производитель') . ' «' . mb_substr($model->name_short, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.producer', 'Редактирование производителя'),
        'url' => [
            '/store/producerBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.producer', 'Просмотреть производителя'),
        'url' => [
            '/store/producerBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.producer', 'Удалить производителя'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/producerBackend/delete', 'id' => $model->id],
            'confirm' => Yii::t('StoreModule.producer', 'Вы уверены, что хотите удалить производителя?'),
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.producer', 'Редактирование') . ' ' . Yii::t('StoreModule.producer', 'производителя'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
