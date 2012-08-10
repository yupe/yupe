<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Восстановление пароля') => array('index'),
    Yii::t('user', 'Управление'),
);

$this->menu = array(
    array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'th-large white', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
    array('icon' => 'th-list', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('recovery-password-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('user', 'Управление восстановлениями пароля');?></h1>

<?php echo CHtml::link(Yii::t('user', 'Поиск восстановлений пароля'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'recovery-password-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'user_id',
                                                               'value' => '$data->user->getFullName()." ({$data->user->nick_name})"'
                                                           ),
                                                           'creation_date',
                                                           'code',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                               'template' => '{view}{delete}',
                                                           ),
                                                       ),
                                                  )); ?>
