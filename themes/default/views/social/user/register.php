<?php
$this->pageTitle = Yii::t('UserModule.user', 'Sign up');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Sign up'));
?>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

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

<div class='row-fluid control-group <?php echo $model->hasErrors('nick_name') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'nick_name', array('class' => 'span6', 'required' => true)); ?>
</div>


<div class="row-fluid  control-group">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('UserModule.user', 'Sign up'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<!-- form -->
