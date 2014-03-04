<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.producer', 'Производители') => array('/shop/producerBackend/index'),
        Yii::t('ShopModule.producer', 'Управление'),
    );

    $this->pageTitle = Yii::t('ShopModule.producer', 'Производители - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.producer', 'Управление производителями'), 'url' => array('/shop/producerBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.producer', 'Добавить производителя'), 'url' => array('/shop/producerBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.producer', 'Производители'); ?>
        <small><?php echo Yii::t('ShopModule.producer', 'управление'); ?></small>
    </h1>
</div>


<?php
 $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'producer-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name'   => 'image',
            'type'   => 'raw',
            'value'  => 'CHtml::image($data->getImageUrl(75), "", array("width" => 75, "height" => 75))',
            'filter' => false
        ),
        array(
            'name'  => 'name_short',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name_short, array("/shop/producerBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/producerBackend/update", "id" => $data->id))',
        ),
        'slug',
        array(
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
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
)); ?>
