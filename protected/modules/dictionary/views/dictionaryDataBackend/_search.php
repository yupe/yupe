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
                <?php echo $form->dropDownListRow($model, 'group_id', CHtml::listData(DictionaryGroup::model()->findAll(), 'id', 'name')); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'code', array('size' => 50, 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'description', array('size' => 60, 'maxlength' => 300)); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '----')); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('DictionaryModule.dictionary', 'Fund dictionary item'),
    )); ?>

<?php $this->endWidget(); ?>
