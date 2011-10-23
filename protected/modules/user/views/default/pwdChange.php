<?php $this->pageTitle = Yii::t('user', 'Новый пароль пользователя'); ?>

<h1><?php echo Yii::t('user', 'Новый пароль пользователя: "{name}"', array('{name}'=>$model->nick_name))?></h1>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => array('/user/default/pwdChange','id'=>$model->id),
    'id' => 'user-form',
    'enableAjaxValidation' => false,
));?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('user', 'Изменить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->