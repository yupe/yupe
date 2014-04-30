<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'name', array('maxlength' => 150, 'size' => 60)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'alias', array('maxlength' => 100, 'size' => 60)); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '----')); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'short_description', array('size' => 60, 'maxlength' => 60)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'description', array('size' => 60, 'maxlength' => 60)); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'parent_id', Category::model()->getFormattedList(), array('empty' => '----', 'encode' => false)); ?>
            </div>
        </div>

    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('CategoryModule.category', 'Find category'),
    )); ?>

<?php $this->endWidget(); ?>
