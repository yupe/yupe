<?php $this->pageTitle = Yii::t('user', 'Профиль'); ?>

<h1>Мой профиль</h1>


<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>


<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'profile-form',
                                                         'enableAjaxValidation' => false,
                                                         'htmlOptions' => array('enctype' => 'multipart/form-data')
                                                    )); ?>



    <?php echo $form->errorSummary($model->profile); ?>



    <div class="row">
        <?php echo $form->labelEx($model->profile, 'blog'); ?>
        <?php echo $form->textField($model->profile, 'blog', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'blog'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'site'); ?>
        <?php echo $form->textField($model->profile, 'site', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'site'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'about'); ?>
        <?php echo $form->textArea($model->profile, 'about', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model->profile, 'about'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'location'); ?>
        <?php echo $form->textField($model->profile, 'location', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'location'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'phone'); ?>
        <?php echo $form->textField($model->profile, 'phone', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model->profile, 'phone'); ?>
    </div>

    <h2>Аватар</h2>

    <?php if ($model->getAvatar()): ?>
    <div class="row">
        <?php echo $model->getAvatar();?>
    </div>
    <?php endif;?>

    <div class="row">
        <?php echo $form->labelEx($model, 'avatar'); ?>
        <?php echo $form->fileField($model, 'avatar', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'useGravatar'); ?>
        <?php echo $form->checkBox($model, 'useGravatar', array('size' => 45, 'maxlength' => 45)); ?>
        <?php echo $form->error($model, 'useGravatar'); ?>
    </div>

    <h2>Социальные сервисы</h2>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'twitter'); ?>
        <?php echo $form->textField($model->profile, 'twitter', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'twitter'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'livejournal'); ?>
        <?php echo $form->textField($model->profile, 'livejournal', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'livejournal'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'vkontakte'); ?>
        <?php echo $form->textField($model->profile, 'vkontakte', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'vkontakte'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'odnoklassniki'); ?>
        <?php echo $form->textField($model->profile, 'odnoklassniki', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'odnoklassniki'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'facebook'); ?>
        <?php echo $form->textField($model->profile, 'facebook', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'facebook'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'yandex'); ?>
        <?php echo $form->textField($model->profile, 'yandex', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'yandex'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model->profile, 'google'); ?>
        <?php echo $form->textField($model->profile, 'google', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model->profile, 'google'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->