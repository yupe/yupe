<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Products') => array('/store/productBackend/index'),
    Yii::t('StoreModule.store', 'Manage'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Manage products');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'product-grid',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtonsCopy'  => true,
        'columns' => array(
            array(
                'type' => 'raw',
                'value' => 'CHtml::image($data->getImageUrl(40, 40, true), "", array("class" => "img-thumbnail"))',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/productBackend/update", "id" => $data->id))',
            ),
            array(
                'name'   => 'mainCategory.name',
                'header' => Yii::t('StoreModule.store', 'Категория'),
                'type'   => 'raw',
                'filter' => CHtml::activeDropDownList($model, 'category', StoreCategory::model()->getFormattedList(), array('encode' => false, 'empty' => '', 'class' => 'form-control')),
                'htmlOptions' => array('width' => '220px'),
            ),
            array(
                'name' => 'producer_id',
                'type' => 'raw',
                'value' => '$data->producerLink',
                'filter' => CHtml::activeDropDownList($model, 'producer_id', Producer::model()->getFormattedList(), array('encode' => false, 'empty' => '', 'class' => 'form-control'))
            ),
            array(
                'name' => 'price',
                'value' => '(float)$data->price',
                'htmlOptions' => array('width' => '60px'),
            ),
            'sku',
            array(
                'name' => 'status',
                'type' => 'raw',
                'filter' => $model->getStatusList(),
                'value'  => '$data->getStatusTitle()'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
