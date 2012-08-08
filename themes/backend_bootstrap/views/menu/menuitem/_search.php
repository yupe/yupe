<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions'=> array( 'class' => 'well' ),
));
?>
<fieldset class="inline">
    <div class="row-fluid control-group">
        <div class="span1">
            <?php echo $form->textFieldRow($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 300)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'href', array('size' => 60, 'maxlength' => 300)); ?>
        </div>
    </div>
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'parent_id', $model->parentList, array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'condition_name', $model->getConditionList(false, 0), array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
        </div>

        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'condition_denial', $model->conditionDenialList, array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group">
        <div class="span2">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
        </div>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'encodeLabel' => false,
        'label' => '<i class="icon-search icon-white"></i> '.Yii::t('menu', 'Искать'),
     )); ?>
</fieldset>
<?php $this->endWidget(); ?>