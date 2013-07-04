<?php
$this->pageTitle = Yii::t('user', 'Войти');
$this->breadcrumbs = array('Войти');
?>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'login-form',
        'type' => 'vertical',
        'inlineErrors' => true,
    )
); ?>

<?php echo $form->errorSummary($model); ?>

<div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>'>
    <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span6', 'required' => true)); ?>
</div>

<?php if ($this->getModule()->sessionLifeTime > 0): ?>
    <div class='row-fluid control-group <?php echo $model->hasErrors('remember_me') ? 'error' : ''; ?>'>
        <?php echo $form->checkBoxRow($model, 'remember_me'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->getState('badLoginCount', 0) >= 3 && CCaptcha::checkRequirements('gd')): ?>
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
            'icon' => 'signin',
            'label' => Yii::t('UserModule.user', 'Войти'),
        )
    ); ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'link',
            'label' => Yii::t('UserModule.user', 'Регистрация'),
            'url' => Yii::app()->createUrl('/user/account/registration'),
        )
    ); ?>
</div>

<?php echo CHtml::link(Yii::t('UserModule.user', 'Забыли пароль?'), array('/user/account/recovery')) ?>

<?php $this->endWidget(); ?>
<!-- form -->