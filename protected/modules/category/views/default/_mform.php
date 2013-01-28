<?php
    if ($model->hasErrors())
        echo $form->errorSummary($model);
?>

    <div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo CHtml::textField('Category[' . $model->lang . '][name]', $model->name, array('class' => 'span7','size' => 60, 'maxlength' => 150)); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
            'name'        => 'Category['.$model->lang.'][description]',
            'value'       => $model->description,
            'options'     => $this->module->editorOptions,
            'htmlOptions' => array('id' => 'editor-' . $model->lang),
        )); ?>
            <br /><?php echo $form->error($model, 'Category['.$model->lang.'][description]'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('short_description')?'error':'' ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget($this->module->editor, array(
                'name'        => 'Category['.$model->lang.'][short_description]',
                'value'       => $model->short_description,
                'options'     => $this->module->editorOptions,
                'htmlOptions' => array('id' => 'editor-short-' . $model->lang),
            )); ?>
            <br /><?php echo $form->error($model, 'Category['.$model->lang.'][short_description]'); ?>
        </div>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("status") ? "error" : ""; ?>'>
        <?php echo CHtml::dropDownList('Category[' . $model->lang . '][status]', $model->status, $model->getStatusList(),array('class' => 'span7')); ?>
    </div>