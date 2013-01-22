<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'id'); ?>
        <?php echo $form->textFieldRow($model, 'user_id'); ?>
        <?php echo $form->textFieldRow($model, 'creation_date'); ?>
        <?php echo $form->textFieldRow($model, 'code', array('size' => 32, 'maxlength' => 32)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'type'        => 'primary',
        'encodeLabel' => false,
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> '.Yii::t('UserModule.user', 'Искать пароль'),
    )); ?>

<?php $this->endWidget(); ?>
