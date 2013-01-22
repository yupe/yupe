<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'id', array('size' => 10, 'maxlength' => 10)); ?> 
        <?php echo $form->textFieldRow($model, 'model', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'model_id', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'creation_date'); ?>
        <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'url', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textAreaRow($model, 'text', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
        <?php echo $form->textFieldRow($model, 'ip', array('size' => 20, 'maxlength' => 20)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('CommentModule.comment', 'Искать комментарии'),
    )); ?>

<?php $this->endWidget(); ?>
