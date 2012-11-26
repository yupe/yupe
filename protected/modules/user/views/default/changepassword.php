<?php
$this->pageTitle = Yii::t('user', 'Изменение пароля');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    $model->nick_name,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Пользователь')),
    array('icon' => 'pencil', 'label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('/user/default/update', 'id' => $model->id)),
    array('icon' => 'eye-open', 'label' => Yii::t('user', 'Просмотр пользователя'), 'url' => array('/user/default/view', 'id' => $model->id)),
    array('icon' => 'lock', 'label' => Yii::t('user', 'Изменить пароль пользователя'), 'url' => array('/user/default/changepassword', 'id' => $model->id)),
    array('icon' => 'trash', 'label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
        'submit' => array('/user/default/delete', 'id' => $model->id),
        'confirm' => 'Подтверждаете удаление ?'),
    ),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/index')),
);
?>

<h1><?php echo Yii::t('user', 'Изменение пароля'); ?> "<?php echo $model->getFullName(); ?> (<?php echo $model->nick_name; ?>)"</h1>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm',array(
        'id'                     => 'change-user-password-form',
        'enableClientValidation' => true
    )); ?>

    <?php echo $form->errorSummary($changePasswordForm); ?>

    <div class="row">
        <?php echo $form->labelEx($changePasswordForm, 'password'); ?>
        <?php echo $form->passwordField($changePasswordForm, 'password'); ?>
        <?php echo $form->error($changePasswordForm, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($changePasswordForm, 'cPassword'); ?>
        <?php echo $form->passwordField($changePasswordForm, 'cPassword'); ?>
        <?php echo $form->error($changePasswordForm, 'cPassword'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('user', 'Изменить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->