<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset class="inline">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5', 'size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'size' => 60, 'maxlength' => 300)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('DictionaryModule.dictionary', 'Find dictionary'),
    )); ?>

<?php $this->endWidget(); ?>
