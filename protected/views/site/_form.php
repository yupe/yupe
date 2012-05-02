<div class="form">

    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registration-form',
            'enableAjaxValidation' => false,
        ));
    ?>

    <p class="note">Заполните поля, необходимые для регистрации</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'replyPassword'); ?>
        <?php echo $form->passwordField($model, 'replyPassword', array('size' => 32, 'maxlength' => 32)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Регистрация'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->