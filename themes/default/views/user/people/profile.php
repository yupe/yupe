<?php
$this->pageTitle = 'Мой профиль';
$this->breadcrumbs = array($this->pageTitle);
?>

<h1>Мой профиль</h1>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm',array(
        'id' => 'add-user-form',
        'enableClientValidation' => true
    )); ?>

    <p class="note"><?php echo Yii::t('user', 'Поля, отмеченные * обязательны для заполнения')?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'location'); ?>
        <?php echo $form->textField($model, 'location', array('size' => 25, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'location'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'site'); ?>
        <?php echo $form->textField($model, 'site', array('size' => 25, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'site'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'birth_date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,            
            'attribute' => 'birth_date',
            'options'   => array(
                'dateFormat' => 'yy-mm-dd'
             )          
        )); ?>
        <?php echo $form->error($model, 'birth_date'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'about'); ?>
        <?php echo $form->textArea($model, 'about', array('rows' => 7, 'cols' => 45)); ?>
        <?php echo $form->error($model, 'about'); ?>
    </div>    

    <div class="row">
        <?php echo $form->labelEx($model, 'gender'); ?>
        <?php echo $form->dropDownList($model, 'gender', $model->getGendersList()); ?>
        <?php echo $form->error($model, 'gender'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('ОБНОВИТЬ МОЙ ПРОФИЛЬ'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->