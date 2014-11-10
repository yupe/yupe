<?php
/* @var $model Export */
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Экспорт товаров') => ['/store/exportBackend/index'],
    Yii::t('StoreModule.store', 'Управление'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Экспорт товаров - управление');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление экспортом'), 'url' => ['/store/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить выгрузку'), 'url' => ['/store/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Выгрузки товаров'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'управление'); ?></small>
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
                    return CHtml::link($data->name, array("/store/exportBackend/update", "id" => $data->id));
                },
            ],
            [
                'header' => 'URL',
                'type' => 'raw',
                'value' => function ($data) {
                    $url = Yii::app()->createAbsoluteUrl('/store/export/view', ['id' => $data->id]);
                    return CHtml::link($url, $url);
                }
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]
); ?>
