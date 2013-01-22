<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'id', array('class' => 'span5 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5 popover-help', 'size' => 60, 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('GalleryModule.gallery', 'Искать галерею'),
    )); ?>

<?php $this->endWidget(); ?>
