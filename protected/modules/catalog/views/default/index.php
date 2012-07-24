<?php
$this->breadcrumbs=array(
	'товары'=>array('index'),
	Yii::t('yupe','Управление'),
);
$this-> pageTitle ="товары - "."Yii::t('yupe','управление')";
$this->menu=array(
array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление товарами'),'url'=>array('/catalog/default/index')),
array('icon'=> 'file','label' => Yii::t('yupe','Добавить товар'), 'url' => array('/catalog/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('yupe','товары'));?>    <small><?php echo Yii::t('yupe','управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#">Поиск товаров</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('good-grid', {
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
    <?php echo Yii::t('yupe','В данном разделе представлены средства управления');?> <?php echo Yii::t('yupe','товарами');?>.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.BootGridView',array(
'id'=>'good-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.BootPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		'category_id',
		'name',
		'price',
		'article',
		'image',
		/*
		'short_description',
		'description',
		'alias',
		'data',
		'status',
		'create_time',
		'update_time',
		'user_id',
		'change_user_id',
		*/
array(
'class'=>'bootstrap.widgets.BootButtonColumn',
),
),
)); ?>
