<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10,'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'category_id', array('class' => 'span5', 'maxlength'=>10,'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'parent_id', array('class' => 'span5', 'size' => 60,'maxlength' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 300,'size' => 60)); ?>
        <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
        <?php echo $form->textFieldRow($model, 'file', array('class' => 'span5', 'maxlength'=>500, 'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'creation_date', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'user_id', array('class' => 'span5', 'maxlength' => 10, 'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span5', 'maxlength' => 150, 'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'type', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'status', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'        =>'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> '.Yii::t('ImageModule.image','Find image'),
    )); ?>

<?php $this->endWidget(); ?>
