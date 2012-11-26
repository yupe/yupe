<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array('class' => 'well search-form'),
        ));
?>

<fieldset>
    <?php echo $form->textFieldRow($model, 'id'); ?>

    <?php echo $form->textFieldRow($model, 'name'); ?>

    <?php echo $form->textFieldRow($model, 'code'); ?>

    <?php echo $form->textFieldRow($model, 'description'); ?>

    <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
</fieldset>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'encodeLabel' => false,
    'label' => '<i class="icon-search icon-white"></i> ' . Yii::t('menu', 'Искать')
));
?>


<?php $this->endWidget(); ?>