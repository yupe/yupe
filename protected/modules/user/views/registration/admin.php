<script type='text/javascript'>
    function sendEmailNotify(id) {
        var href = $(this).attr('href');
        var id = parseInt(href.substr(-1, 1));
        if (!id) {
            alert('<?php echo Yii::t('user', 'Ошибка при отправке уведомления!')?>');
        } else {
            if (window.confirm('<?php echo Yii::t('user', 'Пользователю на email будет отправлено уведомление! Продолжить?');?>')) {
                alert('Отправка уведомления!');
                $.post('', {'id':id}, function(response) {
                    alert(response);
                }, 'json');
            }
        }
        return false;
    }

</script>

<?php $this->pageTitle = Yii::t('user', 'Управление регистрациями'); ?>

<?php

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Регистрации') => array('admin'),
    Yii::t('user', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список регистраций'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Восстановление пароля'), 'url' => array('/user/recoveryPassword/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('registration-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('user', 'Управление регистрациями')?></h1>



<?php echo CHtml::link(Yii::t('user', 'Поиск регистраций'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
                                               'model' => $model,
                                          )); ?>
</div><!-- search-form -->


<?php
//'buttons' => array(
//		'sendMail' => array(
//			'label'    => Yii::t('user','Отправить пользователю уведомление об активации аккаунта!'),
//			'url'      => 'Yii::app()->createUrl("user/notifyActivationEmail",array("id" => $data->id))',
//			'click'    => 'sendEmailNotify', //yupe.user.sendActivationNotify('.$model->id.')
//			'imageUrl' => Yii::app()->baseUrl.'/web/images/mail.png'
//		),
//	),
//    'template'=>'{sendMail}',
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
                                                       'id' => 'registration-grid',
                                                       'dataProvider' => $model->search(),
                                                       'columns' => array(
                                                           'id',
                                                           'creationDate',
                                                           'nickName',
                                                           'email',
                                                           'code',
                                                           array(
                                                               'class' => 'CButtonColumn',
                                                           ),
                                                       ),
                                                  )); ?>
