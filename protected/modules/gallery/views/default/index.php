<?php
$this->breadcrumbs=array(    
    Yii::app()->getModule('gallery')->getCategory() => array('admin'),
	Yii::t('gallery','Галереи')=>array('index'),
	Yii::t('gallery','Управление'),
);
$this->pageTitle = Yii::t('gallery','Галереи - управление');

$this->menu=array(
    array('icon'=> 'list-alt white', 'label' => Yii::t('gallery','Управление Галереями'),'url'=>array('/gallery/default/index')),
    array('icon'=> 'file','label' => Yii::t('gallery','Добавить Галерею'), 'url' => array('/gallery/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo ucfirst(Yii::t('gallery','Галереи'));?>    <small><?php echo Yii::t('gallery','управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse"  data-target="#search-toggle" >
    <i class="icon-search"></i>
    <?php echo CHtml::link(Yii::t('gallery','Поиск Галерей'), '#', array('class' => 'search-button'));?>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('gallery-grid', {
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
    <?php echo Yii::t('gallery','В данном разделе представлены средства управления');?> <?php echo Yii::t('gallery','Галереями');?>.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'gallery-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.TbPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
		'description',
		'status',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
