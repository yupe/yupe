<?php
$this->breadcrumbs = array(
	$this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
    Yii::t('MailModule.mail','Почтовые сообщения') => array('/mail/defaultAdmin/index'),
    Yii::t('MailModule.mail','Почтовые шаблоны'),
);
$this->pageTitle = Yii::t('MailModule.mail','Список почтовых шаблонов');

$this->menu = array(
	array('label' => Yii::t('MailModule.mail', 'Почтовые сообщения'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Управление'),'url'=>array('/mail/defaultAdmin/index')),
	)),
	array('label' => Yii::t('MailModule.mail', 'Почтовые события'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Список событий'),'url'=>array('/mail/eventAdmin/index')),
		array('icon'=> 'plus-sign','label' => Yii::t('MailModule.mail','Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
	)),
	array('label' => Yii::t('MailModule.mail', 'Почтовые шаблоны'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
		array('icon'=> 'plus-sign','label' => Yii::t('MailModule.mail','Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
	)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Почтовые шаблоны');?> <small><?php echo Yii::t('MailModule.mail','управление');?></small></h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('MailModule.mail','Поиск почтовых шаблонов');?></a>    <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php Yii::app()->clientScript->registerScript('search', "
    $('.search-form').submit(function(){         
        $.fn.yiiGridView.update('mail-template-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->renderPartial('_search', array('model'=>$model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('MailModule.mail','В данном разделе представлены средства управления почтовыми шаблонами'); ?>
</p>

<?php
$this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'mail-template-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'code',
        array(
            'name'   => 'event_id',
            'value'  => '$data->event->name',
            'filter' => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name')
        ),
        'name',
        'theme',
        'from',
        'to',
        array(
            'name'  => 'status',
            'value' => '$data->getStatus()',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>
