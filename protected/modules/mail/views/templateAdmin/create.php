<?php
$this->breadcrumbs=array(
	$this->module->getCategory() => array('index'),
        Yii::t('MailModule.mail','Mail events')=>array('/mail/eventAdmin/'),
	Yii::t('MailModule.mail','Mail templates')=>array('index'),
	Yii::t('MailModule.mail','Create'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Templates list'),'url'=>array('/mail/templateAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail','Create template'),'url'=>array('/mail/templateAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Mail templates');?>  <small><?php echo Yii::t('MailModule.mail','adding');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>