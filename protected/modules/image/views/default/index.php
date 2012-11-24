<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array(''),
	Yii::t('image','Изображения')=>array('index'),
	Yii::t('image','Управление'),
);
$this-> pageTitle = Yii::t('image','Изображения управление');
$this->menu=array(
array('icon'=> 'list-alt white', 'label' => Yii::t('image', 'Список изображений	'), 'url'=>array('/image/default/index')),
array('icon'=> 'plus-sign', 'label' => Yii::t('image', 'Добавить изображение'), 'url' => array('/image/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('image','Изображения'));?>    <small><?php echo Yii::t('image','управление');?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('image', 'Поиск изображений'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form').submit(function() {
        $.fn.yiiGridView.update('image-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
    $this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('image','В данном разделе представлены средства управления изображениями');?>
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'image-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.TbPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		array(
			'name' => Yii::t('image','file'),
			'type' => 'raw',
			'value' => 'CHtml::image($data->file,$data->alt,array("width" =>75, "height" => 75))'
		),		
		array(
           'name'  => 'category_id',
           'value' => '$data->getCategoryName()'
        ),
		'name',
		'alt',		
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
