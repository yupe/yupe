<?php
$this->pageTitle = Yii::t('user', 'Восстановление пароля');
$this->breadcrumbs = array('Восстановление пароля');
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

<div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
    <span class="help-block">
        <?php echo Yii::t('UserModule.user', 'Введите email, указанный при регистрации'); ?>
    </span>
</div>

<div class="row-fluid  control-group">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user', 'Восстановить пароль'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<!-- form -->
