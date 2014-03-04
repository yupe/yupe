<?php
    $this->breadcrumbs = array(      
        Yii::t('ShopModule.attribute', 'Атрибуты') => array('/shop/attributeBackend/index'),
        Yii::t('ShopModule.attribute', 'Управление'),
    );

    $this->pageTitle = Yii::t('ShopModule.attribute', 'Атрибуты - управление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.attribute', 'Управление атрибутами'), 'url' => array('/shop/attributeBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.attribute', 'Добавить атрибут'), 'url' => array('/shop/attributeBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.attribute', 'Атрибуты'); ?>
        <small><?php echo Yii::t('ShopModule.attribute', 'управление'); ?></small>
    </h1>
</div>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'attribute-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'  => 'id',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/attributeBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/attributeBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'title',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->title, array("/shop/attributeBackend/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'type',
            'type'  => 'text',
            'value' => '$data->getTypeTitle($data->type)',
            'filter' => $model->getTypesList()
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>