<?php
/* @var $model Export */
$this->breadcrumbs = [
    Yii::t('YmlModule.default', 'Products export') => ['/yml/exportBackend/index'],
    Yii::t('YmlModule.default', 'Manage'),
];

$this->pageTitle = Yii::t('YmlModule.default', 'Products export - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YmlModule.default', 'Manage export lists'), 'url' => ['/yml/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YmlModule.default', 'Create export list'), 'url' => ['/yml/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('YmlModule.default', 'Products export'); ?>
        <small><?= Yii::t('YmlModule.default', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'export-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => [
            [
                'name' => 'id',
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::link($data->name, ["/yml/exportBackend/update", "id" => $data->id]);
                },
            ],
            [
                'header' => 'URL',
                'type' => 'raw',
                'value' => function ($data) {
                    $url = Yii::app()->createAbsoluteUrl('/yml/export/view', ['id' => $data->id]);
                    return CHtml::link($url, $url, ['target' => '_blank']);
                }
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
); ?>
