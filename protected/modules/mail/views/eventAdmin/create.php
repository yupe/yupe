<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
    Yii::t('MailModule.mail','Почтовые сообщения') => array('/mail/defaultAdmin/index'),
    Yii::t('MailModule.mail','Почтовые события')=>array('/mail/eventAdmin/index'),
    Yii::t('MailModule.mail','Добавление'),
);

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
    <h1><?php echo Yii::t('MailModule.mail','Почтовые события');?>
        <small><?php echo Yii::t('MailModule.mail','добавление');?></small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form', array('model'=>$model)); ?>