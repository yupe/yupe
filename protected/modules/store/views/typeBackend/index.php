<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.type', 'Типы товаров') => array('/store/typeBackend/index'),
    Yii::t('StoreModule.type', 'Управление'),
);

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - управление');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление типами'), 'url' => array('/store/typeBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.type', 'Добавить тип'), 'url' => array('/store/typeBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Типы товаров'); ?>
        <small><?php echo Yii::t('StoreModule.type', 'управление'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'type-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/typeBackend/update", "id" => $data->id))',
            ),
            array(
                'name'  => 'main_category_id',
                'value' => function($data) {
                        return $data->category ? $data->category->name : '---';
                    },
                'filter' => false
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
