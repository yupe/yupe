<?php
$this->breadcrumbs=array(   
	Yii::t('MailModule.mail','Mail templates')=>array('index'),
    Yii::t('MailModule.mail','Mail events')=>array('/mail/eventBackend/index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('MailModule.mail','Edit'),
);
$this->pageTitle = Yii::t('MailModule.mail','Edit mail template');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Templates list'),'url'=>array('/mail/templateBackend/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail','Create template'),'url'=>array('/mail/templateBackend/create')),
    array('icon'=>'pencil white','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','Edit template '),'url'=>array('mail/templateAdmin/update','id'=>$model->id)),
    array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','View template'),'url'=>array('/mail/templateBackend/view','id'=>$model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Edit template');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>