<?php
$this->pageTitle = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'Password recovery'));
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'login-form',
        'type' => 'vertical',
        'inlineErrors' => true,
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
); ?>

    <?php echo $form->errorSummary($model); ?>

        <div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
            <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span6', 'required' => true)); ?>
        </div>

        <div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
            <?php echo $form->passwordFieldRow($model, 'cPassword', array('class' => 'span6', 'required' => true)); ?>
        </div>


        <div class="row-fluid  control-group">
            <?php
            $this->widget(
                'bootstrap.widgets.TbButton',
                array(
                    'buttonType' => 'submit',
                    'type' => 'primary',
                    'icon' => 'signin',
                    'label' => Yii::t('UserModule.user', 'Change password'),
                )
            ); ?>
        </div>

    <?php $this->endWidget(); ?>
