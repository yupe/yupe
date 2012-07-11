<?php
$this->breadcrumbs=array(
	'задания'=>array('index'),
	'Управление',
);
$this-> pageTitle ="задания - управление";
$this->menu=array(
array('icon'=> 'list-alt white', 'label' => 'Управление заданиями','url'=>array('/queue/default/index')),
array('icon'=> 'file', 'label' => 'Добавить задание', 'url' => array('/queue/default/create')),
);
?>
<div class="page-header">
    <h1>задания    <small>управление</small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"
        data-toggle="collapse"
        data-target="#search-toggle" >
    <a class="search-button" href="#">Поиск заданий</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('queue-grid', {
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

<p>В данном разделе представлены средства управления заданиями.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.BootGridView',array(
'id'=>'queue-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.BootPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		 array(
		 	'name'  => 'worker',
		 	'value' => 'isset(Yii::app()->queue->workerNamesMap[$data->worker]) ? Yii::app()->queue->workerNamesMap[$data->worker] : $data->worker'
		 ),
		'create_time',		
		'start_time',
		'complete_time',		
		 array(
		 	'name'  => 'status',
		 	'value' => '$data->getStatus()'
		 ),
		'notice',
		
array(
'class'=>'bootstrap.widgets.BootButtonColumn',
),
),
)); ?>
