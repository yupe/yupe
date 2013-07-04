<?php
$this->pageTitle = Yii::t('user', 'Регистрация');
$this->breadcrumbs = array('Регистрация');
?>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'registration-form',
        'type' => 'vertical',
        'inlineErrors' => true,
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row-fluid control-group <?php echo $model->hasErrors('nick_name') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'nick_name', array('class' => 'span6', 'required' => true)); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>'>
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span6', 'required' => true)); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors('cPassword') ? 'error' : ''; ?>'>
    <?php echo $form->passwordFieldRow($model, 'cPassword', array('class' => 'span6', 'required' => true)); ?>
</div>

<?php if ($module->showCaptcha && CCaptcha::checkRequirements()): ?>
    <?php $this->widget(
        'CCaptcha',
        array(
            'showRefreshButton' => true,
            'imageOptions' => array(
                'width' => '150',
            ),
            'buttonOptions' => array(
                'class' => 'btn',
            ),
            'buttonLabel' => '<i class="icon-repeat"></i>',
        )
    ); ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('verifyCode') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'verifyCode', array('class' => 'span3', 'required' => true)); ?>
        <span class="help-block">
            <?php echo Yii::t('UserModule.user', 'Введите текст указанный на картинке'); ?>
        </span>
    </div>
<?php endif; ?>

<div class="row-fluid  control-group">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user', 'Зарегистрироваться'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<!-- form -->
