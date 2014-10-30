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
        'columns' => array(
            array(
                'type' => 'raw',
                'value' => 'CHtml::image($data->getImageUrl(40, 40, true), "", array("class" => "img-thumbnail"))',
            ),
            'sku',
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
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'price',
                'value'    => function($data) {
                        return (float)$data->price;
                    },
                'editable' => array(
                    'url'    => $this->createUrl('/store/productBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'price', array('class' => 'form-control')),
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/store/productBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Product::STATUS_ACTIVE => ['class' => 'label-success'],
                    Product::STATUS_NOT_ACTIVE => ['class' => 'label-info'],
                    Product::STATUS_ZERO => ['class' => 'label-default'],
                ],
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'in_stock',
                'url'     => $this->createUrl('/store/productBackend/inline'),
                'source'  => $model->getInStockList(),
                'options' => [
                    Product::STATUS_IN_STOCK => ['class' => 'label-success'],
                    Product::STATUS_NOT_IN_STOCK => ['class' => 'label-danger']
                ],
            ),
            'quantity',
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
