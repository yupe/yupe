<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'add-image-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data')
    )); ?>


    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 7, 'cols' => 65)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alt'); ?>
        <?php echo $form->textField($model, 'alt', array('size' => 50, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'alt'); ?>
    </div>

    <?php if ($model->file !== null) : ?>
    
    <div class="row">
        <?php
        echo CHtml::image(
            $model->getUrl(190), $model->alt
        ); ?>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'file'); ?>
        <?php echo $form->fileField($model, 'file', array('size' => 40, 'maxlength' => 500)); ?>
        <?php echo $form->error($model, 'file'); ?>
    </div>

    <div class="row buttons">
        <?php
        echo CHtml::submitButton(
            $model->file !== null
            ? Yii::t('image', 'Сохранить изображение')
            : Yii::t('image', 'Добавить изображение')
        ); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->