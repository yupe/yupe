<?php
/**
 * Отображение для update:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs=array(   
    Yii::t('MailModule.mail', 'Mail events')=>array('index'),
    $model->name=>array('view', 'id'=>$model->id),
    Yii::t('MailModule.mail', 'Edit'),
);
$this->pageTitle = Yii::t('MailModule.mail', 'Edit mail event');
$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Messages list'),'url'=>array('/mail/eventBackend/index')),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail', 'Create event'),'url'=>array('/mail/eventBackend/create')),
    array('icon'=>'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('MailModule.mail', 'Edit event'),'url'=>array('mail/eventAdmin/update', 'id'=>$model->id)),
    array('icon'=>'eye-open', 'encodeLabel'=> false, 'label' => Yii::t('MailModule.mail', 'Show template'),'url'=>array('/mail/eventBackend/view', 'id'=>$model->id)),
    array('icon'=> 'plus-sign', 'label' =>  Yii::t('MailModule.mail', 'Create template'),'url'=>array('/mail/templateBackend/create/', 'eid' => $model->id)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Edit mail message');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>