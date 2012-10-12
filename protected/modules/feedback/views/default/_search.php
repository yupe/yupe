<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', 'delay' : 500 });
    });
");
?>

<fieldset class="inline">
    <div class="span1">
        <?php echo $form->textFieldRow($model, 'id', array('class' => 'popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
    </div>

   <div class="row-fluid control-group">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('feeback', 'Найти сообщения'),
       )); ?>
   </div>
</fieldset>

<?php $this->endWidget(); ?>