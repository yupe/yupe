<?php $this->pageTitle = Yii::t('UserModule.user', 'Сменя пароля'); ?>

<h1><?php echo Yii::t('UserModule.user', 'Восстановление пароля'); ?></h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>


<p><?php echo Yii::t('UserModule.user', 'Укажите свой новый пароль!'); ?></p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cPassword'); ?>
        <?php echo $form->passwordField($model, 'cPassword'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('UserModule.user', 'Изменить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->