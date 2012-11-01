<?php
$this->breadcrumbs = array(
    $this->getModule('social')->getCategory() => array(''),
    Yii::t('social', 'Социализация') => array('/social/default/'),
    Yii::t('social', 'Авторизационные данные') => array('admin'),
    Yii::t('social', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список'), 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('login-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('social', 'Авторизационные данные');?></h1>


<?php echo CHtml::link(Yii::t('social', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'login-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           array(
                                                               'name' => 'user_id',
                                                               'value' => '$data->user->getFullName()." ({$data->user->nick_name})"'
                                                           ),
                                                           'identity_id',
                                                           'type',
                                                           'creation_date',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
