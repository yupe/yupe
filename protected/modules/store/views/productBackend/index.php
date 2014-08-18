<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.product', 'Products') => array('/store/productBackend/index'),
    Yii::t('StoreModule.product', 'Manage'),
);

$this->pageTitle = Yii::t('StoreModule.product', 'Manage products');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.product', 'Manage products'), 'url' => array('/store/productBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.product', 'Add a product'), 'url' => array('/store/productBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.product', 'Products'); ?>
        <small><?php echo Yii::t('StoreModule.product', 'administration'); ?></small>
    </h1>
</div>

<p><?php echo Yii::t('StoreModule.product', 'This section describes products manager'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
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
                'value' => '$data->mainImage ? CHtml::image($data->mainImage->getImageUrl(40, 40, true), "", array("class" => "img-thumbnail")) : ""',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => 'CHtml::link($data->name, array("/store/productBackend/update", "id" => $data->id))',
            ),
            /*array(
                'name' => 'alias',
                'type' => 'raw',
                'value' => 'CHtml::link($data->alias, array("/store/productBackend/update", "id" => $data->id))',
            ),*/
            array(
                'name' => 'category',
                'type' => 'raw',
                'value' => '$data->mainCategory->name',
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
                'name' => 'is_special',
                'type' => 'raw',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "is_special", "Special", array("minus", "star"))',
                'filter' => Yii::app()->getModule('store')->getChoice()
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
    )
); ?>
