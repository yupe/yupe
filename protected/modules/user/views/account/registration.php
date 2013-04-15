<?php
$this->pageTitle = Yii::t('user', 'Регистрация нового пользователя');
$this->breadcrumbs = array('Регистрация нового пользователя');
?>

<h1>Регистрация нового пользователя</h1>

<div class='hint'>Пожалуйста, имя пользователя и пароль заполняйте только латинскими буквами и цифрами.</div>

<br/><br/>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'registration-form'));?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name') ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email') ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password');?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'cPassword'); ?>
        <?php echo $form->passwordField($model, 'cPassword');?>
        <?php echo $form->error($model, 'cPassword'); ?>
    </div>


    <?php if ($module->showCaptcha && CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha', array(
                    'showRefreshButton' => true,
                    'clickableImage' => true,
                    'buttonLabel' => 'обновить',
                    'buttonOptions' => array('class' => 'captcha-refresh-link'),
                )); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
            <div class="hint">
                Введите текст указанный на картинке
            </div>
        </div>
    <?php endif; ?>

    <div class="row submit">
        <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->