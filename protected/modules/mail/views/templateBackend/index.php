<?php
$this->breadcrumbs=array(    
    Yii::t('MailModule.mail','Mail events')=>array('/mail/eventBackend/index'),
    Yii::t('MailModule.mail','Mail templates')=>array('index'),
    Yii::t('MailModule.mail','Management'),
);
$this->pageTitle = Yii::t('MailModule.mail','Mail templates list');

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array('icon' => 'list-alt', 'label' => Yii::t('MailModule.mail','Templates list'),'url'=>array('/mail/templateBackend/index')),
    array('icon' => 'plus-sign','label' => Yii::t('MailModule.mail','Create template'), 'url' => array('/mail/templateBackend/create')),
    array('label' => Yii::t('MailModule.mail', 'Mail events')),
    array('icon' => 'list-alt', 'label' => Yii::t('MailModule.mail','Messages list'),'url'=>array('/mail/eventBackend/index')),
    array('icon' => 'plus-sign','label' => Yii::t('MailModule.mail','Create event'), 'url' => array('/mail/eventBackend/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Mail templates');?> <small><?php echo Yii::t('MailModule.mail','management');?></small></h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('MailModule.mail','Find mail templates');?></a>    <span class="caret"></span>
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
    <?php echo Yii::t('MailModule.mail','This section contain mail message templates management'); ?>
</p>

<?php
$this->widget('yupe\widgets\CustomGridView', array(
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
