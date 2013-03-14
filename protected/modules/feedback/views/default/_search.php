<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'id', array('class' => 'span5', 'maxlength' => 10, 'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 150, 'size' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'theme', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'size' => 60, 'maxlength' => 60)); ?>
        <?php echo $form->dropDownListRow($model, 'type', $model->typeList, array('class' => 'span5')); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span5')); ?>
        <?php echo $form->checkBoxRow($model, 'is_faq', $model->isFaqList, array('class' => 'span5')); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('FeedbackModule.feedback', 'Искать сообщения  '),
    )); ?>

<?php $this->endWidget(); ?>
