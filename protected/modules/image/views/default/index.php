<?php
$this->breadcrumbs=array(
	'изображения'=>array('index'),
	Yii::t('yupe','Управление'),
);
$this-> pageTitle ="изображения - "."Yii::t('yupe','управление')";
$this->menu=array(
array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление изображениями'),'url'=>array('/image/default/index')),
array('icon'=> 'file','label' => Yii::t('yupe','Добавить изображение'), 'url' => array('/image/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('yupe','изображения'));?>    <small><?php echo Yii::t('yupe','управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#">Поиск изображений</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('image-grid', {
data: $(this).serialize()
});
return false;
});
");
    $this->renderPartial('_search',array(
	'model'=>$model,
));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('yupe','В данном разделе представлены средства управления');?> <?php echo Yii::t('yupe','изображениями');?>.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.BootGridView',array(
'id'=>'image-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.BootPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
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
'class'=>'bootstrap.widgets.BootButtonColumn',
),
),
)); ?>
