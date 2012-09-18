<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well form-vertical'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', 'delay' : 500 });
    });
");
?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'description', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'start_add_image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('start_add_image'), 'data-content' => $model->getAttributeDescription('start_add_image'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'stop_add_image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('stop_add_image'), 'data-content' => $model->getAttributeDescription('stop_add_image'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'start_vote', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('start_vote'), 'data-content' => $model->getAttributeDescription('start_vote'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'stop_vote', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('stop_vote'), 'data-content' => $model->getAttributeDescription('stop_vote'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'status', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('contest', 'Искать конкурс'),
    )); ?>

<?php $this->endWidget(); ?>