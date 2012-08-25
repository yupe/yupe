<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<div class="top_text">
    <div class="advertising"><?php echo Yii::t('tenders','Начните экономить прямо сейчас');?> <span><?php echo Yii::t('tenders','Создайте свой тендер');?></span> <?php echo CHtml::link(Yii::t('tenders','Новый тендер'),array('/tenders/my/add/'))?></div>
</div>


<div class="main_content">

<div class="title"><h3><?php echo Yii::t('tenders','Восстановление пароля');?></h3></div>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>


<p>Для восстановления пароля - введите email, указанный при регистрации.</p>

<div class="form_reg_edit">
    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'recovery-password-form',
                                                         'enableClientValidation' => true
                                                    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="list">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email') ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('tenders','Восстановить пароль')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->

</div>