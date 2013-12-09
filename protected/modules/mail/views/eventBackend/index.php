<?php
/**
 * Отображение для index:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs=array(    
    Yii::t('MailModule.mail', 'Mail events')=>array('index'),
    Yii::t('MailModule.mail', 'List'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Events list');

$this->menu = array(
    array('label' => Yii::t('MailModule.mail', 'Mail events')),
    array('icon'=> 'list-alt white', 'label' => Yii::t('MailModule.mail', 'Messages list'),'url'=>array('/mail/eventBackend/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Create event'), 'url' => array('/mail/eventBackend/create')),
    array('label' => Yii::t('MailModule.mail', 'Mail templates')),
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Templates list'),'url'=>array('/mail/templateBackend/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Create template'), 'url' => array('/mail/templateBackend/create')),
);

Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-button').click(function(){
    	$('.search-form').toggle();
    	return false;
    });
    $('.search-form').submit(function(){
    	$.fn.yiiGridView.update('mail-event-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });"
);

?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Mail events');?> <small><?php echo Yii::t('MailModule.mail', 'management');?></small>
    </h1>
</div>
<button class="btn btn-small dropdown-toggle"  data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('MailModule.mail', 'Find mail messages');?></a><span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form').submit(function(){       
        $.fn.yiiGridView.update('mail-event-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);

$this->renderPartial('_search', array('model'=>$model));
?>
</div>

<br/>

<p>
    <?php echo Yii::t('MailModule.mail', 'This section contain mail messages management'); ?>
</p>

<?php
$this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'mail-event-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            'id',
            'code',
            'name',
            array(
                'header' => Yii::t('MailModule.mail', 'Templates'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->templates), array("/mail/templateBackend/index/", "event" => $data->id))',
            ),
            array(
                'header'      => $model->getAttributeLabel('description'),
                'value'       => '$data->shortDescription;',
                'htmlOptions' => array(
                    'style'   => 'width: 20%;'
                ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view}{update}{delete}{add}',
                'buttons'  => array(
                    'add' => array(
                        'label'   => false,
                        'url'     => 'Yii::app()->createUrl("/mail/templateBackend/create/", array("eid" => $data->id))',
                        'options' => array(
                            'class' => 'icon-plus-sign',
                            'title' => Yii::t('MailModule.mail', 'Create mail template'),
                        )
                    )
                )
            ),
        ),
    )
); ?>