<?php
    $this->breadcrumbs = array(      
        Yii::t('ShopModule.type', 'Типы товаров') => array('/shop/typeBackend/index'),
        Yii::t('ShopModule.type', 'Управление'),
    );

    $this->pageTitle = Yii::t('ShopModule.type', 'Типы товаров - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.type', 'Управление типами'), 'url' => array('/shop/typeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.type', 'Добавить тип'), 'url' => array('/shop/typeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.type', 'Типы товаров'); ?>
        <small><?php echo Yii::t('ShopModule.type', 'управление'); ?></small>
    </h1>
</div>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'type-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/typeBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/typeBackend/update", "id" => $data->id))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>