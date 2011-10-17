<?php $this->pageTitle = Yii::t('user', 'Сменя пароля'); ?>

<h1>Восстановление пароля</h1>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>


<p>Укажите свой новый пароль!</p>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm'); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password') ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cPassword'); ?>
        <?php echo $form->passwordField($model, 'cPassword') ?>
    </div>


    <div class="row submit">
        <?php echo CHtml::submitButton('Изменить пароль'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->