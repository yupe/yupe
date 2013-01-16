<?php

$this->breadcrumbs = array(
	$this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
    Yii::t('MailModule.mail','Почтовые сообщения'),
);
$this->pageTitle = Yii::t('MailModule.mail','Почтовые сообщения');

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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form').submit(function(){
	$.fn.yiiGridView.update('mail-event-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="page-header">
    <h1>В разработке</h1>
</div>

