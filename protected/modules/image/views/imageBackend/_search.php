<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->dropDownListRow($model, 'category_id', Category::model()->getFormattedList(), array('class' => 'span5', 'encode' => false, 'empty' => '----')); ?>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 300,'size' => 60)); ?>
        <?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span5', 'maxlength' => 150, 'size' => 60)); ?>
        <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'span5', 'empty' => '----')); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span5','empty' => '----')); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'        =>'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> '.Yii::t('ImageModule.image','Find image'),
    )); ?>

<?php $this->endWidget(); ?>
