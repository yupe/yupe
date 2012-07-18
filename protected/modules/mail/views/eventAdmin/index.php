<?php
$this->breadcrumbs=array(
	'почтовые события'=>array('index'),
	Yii::t('yupe','Управление'),
);
$this-> pageTitle ="почтовые события - "."Yii::t('yupe','управление')";
$this->menu=array(
    array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление почтовыми событиями'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'file','label' => Yii::t('yupe','Добавить почтовое событие'), 'url' => array('/mail/eventAdmin/create')),
    
    array('label' => Yii::t('menu', 'Почтовые шаблоны')),
    
    array('icon'=> 'list-alt white', 'label' => Yii::t('yupe','Управление почтовыми шаблонами'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'file','label' => Yii::t('yupe','Добавить почтовый шаблон'), 'url' => array('/mail/templateAdmin/create')),
    
    
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('yupe','почтовые события');?>    <small><?php echo Yii::t('yupe','управление');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"
        data-toggle="collapse"
        data-target="#search-toggle" >
    <a class="search-button" href="#">Поиск почтовых событий</a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('mail-event-grid', {
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

<p><?php echo Yii::t('yupe','В данном разделе представлены средства управления');?> <?php echo Yii::t('yupe','почтовыми событиями');?>.
</p>


<?php
$dp = $model->search();
//$dp-> sort-> defaultOrder = "";
$this->widget('bootstrap.widgets.BootGridView',array(
'id'=>'mail-event-grid',
'type'=>'condensed ',
'pager'=>array('class'=>'bootstrap.widgets.BootPager', 	'prevPageLabel'=>"←",'nextPageLabel'=>"→"),
'dataProvider'=>$dp,
'filter'=>$model,
'columns'=>array(
		'id',
		'code',
		'name',
                array(
                    'header'=> Yii::t('mail','Шаблонов'),
                    'type'  => 'raw',
                    'value' => 'CHtml::link(count($data->templates),array("/mail/templateAdmin/index/","event" => $data->id))'
                ),
		'description',
                array(
                    'class'    => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{view}{update}{delete}{add}',
                    'buttons'  => array(
                        'add' => array(
                            'label' => false,
                            'url'   => 'Yii::app()->createUrl("/mail/templateAdmin/create/",array("eid" => $data->id))',
                            'options' => array(
                                'class' => 'icon-plus-sign',
                                'title' => Yii::t('menu','Добавить почтвый шаблон')
                            )
                        )
                    )
                ),
),
)); ?>
