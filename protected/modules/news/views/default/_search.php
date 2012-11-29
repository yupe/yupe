<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well'),
        ));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>


<fieldset>
    <?php echo $form->textFieldRow($model, 'id'); ?>
    <?php echo $form->textFieldRow($model, 'date'); ?>
    <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => Yii::t('news', '- не важен -'))); ?>
    <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('news', '- не важно -'))); ?>
    <?php echo $form->textFieldRow($model, 'title', array('maxlength' => 150)); ?>
    <?php echo $form->textFieldRow($model, 'alias', array('maxlength' => 150)); ?>
    <?php echo $form->textFieldRow($model, 'short_text', array('maxlength' => 400)); ?>
    <?php echo $form->textFieldRow($model, 'full_text'); ?>
    <?php echo $form->checkBoxRow($model, 'is_protected', $model->getProtectedStatusList()); ?>
</fieldset>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'type' => 'primary',
    'encodeLabel' => false,
    'buttonType' => 'submit',
    'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('news', 'Найти новость'),
));
?>

<?php $this->endWidget(); ?>