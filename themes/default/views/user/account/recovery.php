<?php
$this->pageTitle = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Password recovery'));
?>
<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'registration-form',
        'type' => 'vertical',
        'inlineErrors' => true,
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
    <span class="help-block">
        <?php echo Yii::t('UserModule.user', 'Enter an email you have used during signup'); ?>
    </span>
</div>

<div class="row-fluid  control-group">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user', 'Recover password'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<!-- form -->
