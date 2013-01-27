<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'category-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('CategoryModule.category', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('CategoryModule.category', 'обязательны.'); ?>
    </div>

    <?php echo  $form->errorSummary($model); ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors("parent_id") ? "error" : ""; ?>'>
        <?php echo  $form->dropDownListRow($model, 'parent_id', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('CategoryModule.category', '--нет--'),'class' => 'span7')); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='control-group <?php echo $model->hasErrors("alias") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>
    <div class='row-fluid control-group <?php echo $model->hasErrors("image") ? "error" : ""; ?>'>
        <?php if (!$model->isNewRecord && $model->image): ?>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->module->uploadPath . '/' . $model->image, $model->name, array('width' => 300, 'height' => 300)); ?>
        <?php endif; ?>
        <?php echo  $form->fileFieldRow($model, 'image', array('class' => 'span5', 'maxlength' => 300, 'size' => 60)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
        'model'       => $model,
        'attribute'   => 'description',
        'options'     => $this->module->editorOptions,
    )); ?>
        <br /><?php echo $form->error($model, 'description'); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("short_description") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget($this->module->editor, array(
        'model'       => $model,
        'attribute'   => 'short_description',
        'options'     => $this->module->editorOptions,
    )); ?>
        <br /><?php echo $form->error($model, 'short_description'); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo  $form->dropDownListRow($model, 'status', $model->statusList,array('class' => 'span7')); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Добавить категорию и продолжить') : Yii::t('CategoryModule.category', 'Сохранить категорию и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Добавить категорию и закрыть') : Yii::t('CategoryModule.category', 'Сохранить категорию и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
