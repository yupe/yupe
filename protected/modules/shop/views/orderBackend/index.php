<?php
/**
 * @var $model ShopOrder
 */
$this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Shop') => array('/shop/shopBackend/index'),
        Yii::t('ShopModule.shop', 'Orders'), //=> array('/shop/ordersBackend/index'),
        //Yii::t('ShopModule.shop', 'Management'),
    );

    $this->pageTitle = Yii::t('ShopModule.shop', 'Orders');

    /*$this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'News management'), 'url' => array('/news/newsBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Create article'), 'url' => array('/news/newsBackend/create')),
    );*/
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Orders'); ?>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('ShopModule.shop', 'Find orders'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('shoporder-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'shoporder-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            //'class' => 'bootstrap.widgets.TbDataColumn',
            'name' => 'create_time',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->formatDateTime($data->create_time, "short", false)'
        ),
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'type'  => 'raw',
            'value' => 'CHtml::link($data->id, array("/shop/orderBackend/update", "id" => $data->id))',
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'recipient',
            'editable' => array(
                'url' => $this->createUrl('/shop/orderBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            //'class' => 'bootstrap.widgets.TbDataColumn',
            'name'  => 'phone',
            /*'editable' => array(
                'url' => $this->createUrl('/shop/orderBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )*/
        ),
        array(
            'name' => 'price',
            'value' => 'Yii::app()->numberFormatter->formatCurrency($data->price, "RUR")'
        ),
        //'date',
        /*array(
           'name'   => 'category_id',
           'value'  => '$data->getCategoryName()',
		   'filter' => CHtml::activeDropDownList($model, 'category_id', Category::model()->getFormattedList(Yii::app()->getModule('news')->mainCategory), array('encode' => false, 'empty' => ''))
        ),*/
        array(
            'class'   => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
)); ?>