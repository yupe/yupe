<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset>
        <?php echo $form->textFieldRow($model, 'id'); ?>
        <?php echo $form->textFieldRow($model, 'name'); ?>
        <?php echo $form->textFieldRow($model, 'code'); ?>
        <?php echo $form->textFieldRow($model, 'description'); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('blog', 'Искать меню'),
    )); ?>

<?php $this->endWidget(); ?>
