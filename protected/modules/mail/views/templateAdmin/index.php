<?php
$this->breadcrumbs=array(
	'почтовые шаблоны'=>array('index'),
	Yii::t('yupe','Управление'),
);
$this-> pageTitle ="почтовые шаблоны - "."Yii::t('yupe','управление')";
$this->menu=array(
    array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление почтовыми шаблонами'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'file','label' => Yii::t('yupe','Добавить почтовый шаблон'), 'url' => array('/mail/templateAdmin/create')),
    
    array('label' => Yii::t('menu', 'Почтовые события')),
    
    array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление почтовыми событиями'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'file','label' => Yii::t('yupe','Добавить почтовое событие'), 'url' => array('/mail/eventAdmin/create')),
 
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','почтовые шаблоны');?>    <small><?php echo Yii::t('yupe','управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"
        data-toggle="collapse"
        data-target="#search-toggle" >
    <a class="search-button" href="#">Поиск почтовых шаблонов</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('mail-template-grid', {
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

<p><?php echo Yii::t('yupe','В данном разделе представлены средства управления');?> <?php echo Yii::t('yupe','почтовыми шаблонами');?>.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.BootGridView',array(
'id'=>'mail-template-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.BootPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		'code',
		array(
                    'name'   => 'event_id',
                    'value'  => '$data->event->name',
                    'filter' => CHtml::listData(MailEvent::model()->findAll(),'id','name')
                ),
		'name',
		'theme',
		'from',		
		'to',		
		array(
                    'name'   => 'status',
                    'value'  => '$data->getStatus()',                    
                ),
		
array(
'class'=>'bootstrap.widgets.BootButtonColumn',
),
),
)); ?>
