<?php $this->pageTitle = Yii::t('user', 'Управление пользователями'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    Yii::t('user', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Добавить пользователя'), 'url' => array('create')),
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Регистрации'), 'url' => array('/user/registration/admin')),    
    array('label' => Yii::t('user', 'Авторизационные данные'), 'url' => array('/user/login/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('user', 'Поиск пользователей'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
	'id',
	array(
	    'name' => 'nick_name',
	    'type' => 'raw',
	    'value' => 'CHtml::link($data->nick_name,array("/user/default/update/","id" => $data->id))'
	),
	'email',
	array(
	    'name' => 'status',
	    'value' => '$data->getStatus()',
	    'filter' => CHtml::activeDropDownList($model, 'status', $model->getStatusList())
	),
	array(
	    'name' => 'access_level',
	    'value' => '$data->getAccessLevel()',
	    'filter' => CHtml::activeDropDownList($model, 'status', $model->getAccessLevelsList())
	),
	'creation_date',
	'last_visit',
	array(
	    'class' => 'CButtonColumn',
	    'template' => '{view} {update} {password} {delete}',
	    'buttons' => array(
		'password' => array(
		    'label' => Yii::t('user', 'Изменить пароль'),
		    'imageUrl' => Yii::app()->request->baseUrl.'/images/key.png',
		    'url' => 'array("pwdChange","id"=>$data->id)',
		    'options' => array(
			'class' => 'pwdChange',
		    ),
		),
	    ),
	),
    ),
));
?>

<?php $this->widget('ext.fancybox.EFancyBox',array(
    'target'=>'.pwdChange',
)); ?>