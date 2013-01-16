<?php
$this->breadcrumbs = array(
	$this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
    Yii::t('MailModule.mail','Почтовые сообщения') => array('/mail/defaultAdmin/index'),
	Yii::t('MailModule.mail','Почтовые события')=>array('/mail/eventAdmin/index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('MailModule.mail','Редактирование'),
);
$this->pageTitle = Yii::t('MailModule.mail','Редактирование почтового события');

$this->menu = array(
	array('label' => Yii::t('MailModule.mail', 'Почтовые сообщения'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Управление'),'url'=>array('/mail/defaultAdmin/index')),
	)),
	array('label' => Yii::t('MailModule.mail', 'Почтовые события'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Список событий'),'url'=>array('/mail/eventAdmin/index')),
		array('icon'=> 'plus-sign','label' => Yii::t('MailModule.mail','Добавить событие'), 'url' => array('/mail/eventAdmin/create')),
	)),
	array('label' => Yii::t('MailModule.mail', 'Почтовое событие')."«".$model->name."»", 'items' => array(
		array('icon'=>'pencil','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','Редактирование события'),
			'url'=>array('/mail/eventAdmin/update','id'=>$model->id)
		),
		array('icon'=>'eye-open','encodeLabel'=> false, 'label' => Yii::t('MailModule.mail','Просмотреть событие'),
			'url'=>array('/mail/eventAdmin/view','id'=>$model->id)
		),
		array('icon'=>'remove', 'label' =>  Yii::t('MailModule.mail','Удалить  событие'),'url'=>'#',
			'linkOptions'=>array(
				'submit'=>array('delete','id'=>$model->id),
				'confirm'=> Yii::t('MailModule.mail','Вы уверены, что хотите удалить?')
			)
		),
	)),
	array('label' => Yii::t('MailModule.mail', 'Почтовые шаблоны'), 'items' => array(
		array('icon'=> 'list-alt', 'label' => Yii::t('MailModule.mail','Список шаблонов'),'url'=>array('/mail/templateAdmin/index')),
		array('icon'=> 'plus-sign','label' => Yii::t('MailModule.mail','Добавить шаблон'), 'url' => array('/mail/templateAdmin/create')),
	)),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MailModule.mail','Редактирование почтового сообщения');?><br />
        <small style="margin-left: -10px;">&laquo; <?php echo  $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo  $this->renderPartial('_form',array('model'=>$model)); ?>