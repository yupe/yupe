<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.producer', 'Производители') => array('/store/producerBackend/index'),
    Yii::t('StoreModule.producer', 'Управление'),
);

$this->pageTitle = Yii::t('StoreModule.producer', 'Производители - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.producer', 'Управление производителями'), 'url' => array('/store/producerBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.producer', 'Добавить производителя'), 'url' => array('/store/producerBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.producer', 'Производители'); ?>
        <small><?php echo Yii::t('StoreModule.producer', 'управление'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'producer-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            'id',
            array(
                'name' => 'image',
                'type' => 'raw',
                'value' => '$data->image ? CHtml::image($data->getImageUrl(50), "", array("width" => 50, "height" => 50, "class" => "img-thumbnail")) : ""',
                'filter' => false
            ),
            array(
                'name' => 'name_short',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name_short, array("/store/producerBackend/update", "id" => $data->id))',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/producerBackend/update", "id" => $data->id))',
            ),
            'slug',
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
                'filter' => $model->getStatusList()
            ),
            //'order',
            /*
            'image',
            'short_description',
            'description',
            */
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
