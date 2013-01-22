<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'nick_name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'first_name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'last_name', array('size' => 60, 'maxlength' => 150)); ?> 
        <?php echo $form->textFieldRow($model, 'creation_date'); ?>
        <?php echo $form->textFieldRow($model, 'change_date'); ?>
        <?php echo $form->dropDownListRow($model, 'gender', $model->getGendersList()); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
        <?php echo $form->dropDownListRow($model, 'access_level', $model->getAccessLevelsList()); ?>
        <?php echo $form->textFieldRow($model, 'last_visit'); ?>
        <?php echo $form->textFieldRow($model, 'registration_date'); ?>
        <?php echo $form->textFieldRow($model, 'registration_ip', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'activation_ip', array('size' => 20, 'maxlength' => 20)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'type'        => 'primary',
        'encodeLabel' => false,
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> '.Yii::t('UserModule.user', 'Искать пользователя'),
    )); ?>

<?php $this->endWidget(); ?>
