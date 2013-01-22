<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'gallery-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('GalleryModule.gallery', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('GalleryModule.gallery', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>
    <div class='control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('GalleryModule.gallery', 'Добавить галерею и продолжить') : Yii::t('GalleryModule.gallery', 'Сохранить галерею и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('GalleryModule.gallery', 'Добавить галерею и закрыть') : Yii::t('GalleryModule.gallery', 'Сохранить галерею и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
