<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'htmlOptions' => array('class' => 'well search-form'),
));
?>
    <fieldset>
        <?php echo $form->dropDownListRow($model, 'type', $model->getTypes()); ?>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5','size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'span5','size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'content', array('class' => 'span5','rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5','rows' => 6, 'cols' => 50)); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('ContentBlockModule.contentblock', 'Find block'),
    )); ?>

<?php $this->endWidget(); ?>