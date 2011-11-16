<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'image-form',
                                                         'enableClientValidation' => true,
                                                         'htmlOptions' => array('enctype' => 'multipart/form-data')
                                                    )); ?>

    <p class="note"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения');?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->textField($model, 'parent_id', array('size' => 50, 'maxlength' => 250)); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'alt'); ?>
        <?php echo $form->textField($model, 'alt', array('size' => 50, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'alt'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 7, 'cols' => 65)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>   

    <?php if ($model->isNewRecord): ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'file'); ?>
        <?php echo $form->fileField($model, 'file', array('size' => 40, 'maxlength' => 500)); ?>
        <?php echo $form->error($model, 'file'); ?>
    </div>
    <?php endif;?>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $model->getTypeList()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('image', 'Добавить изображение')
                                           : Yii::t('image', 'Сохранить изображение')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->