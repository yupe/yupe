<?php
/**
 * Отображение для create:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->breadcrumbs=array(
    $this->module->getCategory() => array('index'),
    Yii::t('MailModule.mail', 'Почтовые события')=>array('index'),
    Yii::t('MailModule.mail', 'Добавление'),
);

$this->menu=array(
    array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail', 'Список событий'),'url'=>array('/mail/eventAdmin/index')),
    array('icon'=> 'plus-sign', 'label' => Yii::t('MailModule.mail', 'Добавить событие'),'url'=>array('/mail/eventAdmin/create')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail', 'Почтовые события');?>
        <small><?php echo Yii::t('MailModule.mail', 'добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>