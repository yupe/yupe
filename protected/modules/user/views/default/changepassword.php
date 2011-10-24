<?php $this->pageTitle = Yii::t('user', 'Изменение пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('admin'),
    $model->nick_name,
);

$this->menu = array(
    array('label' => Yii::t('user', 'Список пользователей'), 'url' => array('index')),
    array('label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('create')),
    array('label' => Yii::t('user', 'Редактирование пользователя'), 'url' => array('update', 'id' => $model->id)),
    array('label' => Yii::t('user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Подтверждаете удаление ?')),
    array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),    
);
?>

<h1><?php echo Yii::t('user', 'Изменение пароля')?> "<?php echo $model->getFullName(); ?> (<?php echo $model->nick_name;?>)"</h1>


<div class="form">
    <?php $form = $this->beginWidget('CActiveForm',array(
        'id' => 'change-user-password-form',
        'enableClientValidation' => true
    )); ?>

    <?php echo $form->errorSummary($changePasswordForm); ?>

    <div class="row">
        <?php echo $form->labelEx($changePasswordForm, 'password'); ?>
        <?php echo $form->passwordField($changePasswordForm, 'password') ?>
        <?php echo $form->error($changePasswordForm, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($changePasswordForm, 'cPassword'); ?>
        <?php echo $form->passwordField($changePasswordForm, 'cPassword') ?>
        <?php echo $form->error($changePasswordForm, 'cPassword'); ?>
    </div>


    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('seeline','Изменить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->