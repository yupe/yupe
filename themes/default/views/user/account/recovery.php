<?php
$this->pageTitle = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Password recovery'));
?>
<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'          => 'registration-form',
        'type'        => 'vertical',
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup(
            $model,
            'email',
            array('hint' => Yii::t('UserModule.user', 'Enter an email you have used during signup'))
        ); ?>
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
                'label'      => Yii::t('UserModule.user', 'Recover password'),
            )
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
