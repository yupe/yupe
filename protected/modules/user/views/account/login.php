<?php $this->pageTitle = Yii::t('user', 'Авторизация'); ?>

<div class="top_text">
    <div class="advertising"><?php echo Yii::t('tenders','Начните экономить прямо сейчас');?> <span><?php echo Yii::t('tenders','Создайте свой тендер');?></span> <?php echo CHtml::link(Yii::t('tenders','Новый тендер'),array('/tenders/my/add/'))?></div>
</div>


<div class="main_content">

<div class="title"><h3><?php echo Yii::t('tenders','Авторизация');?></h3></div>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>

<div class="form_reg_edit">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'login-form',
                                                         'enableClientValidation' => true
                                                    ));?>

    <?php echo $form->errorSummary($model); ?>

    <div class="list">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email') ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="list">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password') ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="list">
        <p class="hint">
            <?php echo CHtml::link(Yii::t('user', "Регистрация"), array('/user/account/registration')); ?>
            | <?php echo CHtml::link(Yii::t('user', "Восстановление пароля"), array('/user/account/recovery')) ?>
        </p>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('tenders','Войти')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget',array('action' => '/social/social/login/'));?>

</div>
