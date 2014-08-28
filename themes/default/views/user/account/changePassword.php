<?php
$this->pageTitle = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Password recovery'));
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'          => 'login-form',
        'type'        => 'vertical',
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

<div class="row">
    <div class="col-xs-12">
        <?php echo $form->errorSummary($model); ?>

    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup($model, 'cPassword'); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'context'    => 'primary',
                'icon'       => 'glyphicon glyphicon-signin',
                'label'      => Yii::t('UserModule.user', 'Change password'),
            )
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
