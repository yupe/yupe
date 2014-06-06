<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.product', 'Products') => array('/shop/productBackend/index'),
    Yii::t('ShopModule.product', 'Manage'),
);

$this->pageTitle = Yii::t('ShopModule.product', 'Manage products');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.product', 'Manage products'), 'url' => array('/shop/productBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.product', 'Add a product'), 'url' => array('/shop/productBackend/create')),
);
?>
    <div class="page-header">
        <h1>
            <?php echo Yii::t('ShopModule.product', 'Products'); ?>
            <small><?php echo Yii::t('ShopModule.product', 'administration'); ?></small>
        </h1>
    </div>

    <p><?php echo Yii::t('ShopModule.product', 'This section describes products manager'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id' => 'product-grid',
    'type' => 'condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('width' => '50px'),
        ),
        array(
            'type' => 'raw',
            'value' => '$data->mainImage ? CHtml::image($data->mainImage->getImageUrl(40, 40, true)) : ""',
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name, array("/shop/productBackend/update", "id" => $data->id))',
        ),
        /*array(
            'name' => 'alias',
            'type' => 'raw',
            'value' => 'CHtml::link($data->alias, array("/shop/productBackend/update", "id" => $data->id))',
        ),*/
        array(
            'name' => 'category',
            'type' => 'raw',
            'value' => '$data->mainCategory->name',
            'filter' => CHtml::activeDropDownList($model, 'category', Category::model()->getFormattedList(), array('encode' => false, 'empty' => '')),
            'htmlOptions' => array('width' => '220px'),
        ),
        array(
            'name' => 'producer_id',
            'type' => 'raw',
            'value' => '$data->producerLink',
            'filter' => CHtml::activeDropDownList($model, 'producer_id', Producer::model()->getFormattedList(), array('encode' => false, 'empty' => ''))
        ),
        array(
            'name' => 'price',
            'htmlOptions' => array('width' => '60px'),
        ),
        'sku',
        array(
            'name' => 'is_special',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "is_special", "Special", array("minus", "star"))',
            'filter' => Yii::app()->getModule('shop')->getChoice()
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("time", "ok-sign", "minus-sign"))',
            'filter' => $model->getStatusList()
        ),
        array(
            'name' => 'type_id',
            'type' => 'raw',
            'value' => '$data->type->name',
            'filter' => Type::model()->getFormattedList(),
        ),
        /*array(
            'name'   => 'user_id',
            'type'   => 'raw',
            'value'  => 'CHtml::link($data->user->getFullName(), array("/user/catalogBackend/view", "id" => $data->user->id))',
            'filter' => CHtml::listData(User::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(),'id','nick_name')
        ),*/
        array(
            'name' => 'create_time',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
            'htmlOptions' => array('width' => '90px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>