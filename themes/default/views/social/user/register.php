<?php
$this->pageTitle = Yii::t('UserModule.user', 'Sign up');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Sign up'));
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'           => 'social-registration-form',
        'type'         => 'vertical',
        'inlineErrors' => true,
        'htmlOptions'  => array(
            'class' => 'well',
        )
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nick_name'); ?>
    </div>
</div>

<?php if (!isset($authData['email'])): { ?>
    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'email'); ?>
        </div>
    </div>
<?php } endif; ?>

<div class="row">
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('UserModule.user', 'Sign up'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<!-- form -->
