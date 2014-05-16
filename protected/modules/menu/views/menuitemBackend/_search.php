<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'title'); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '---')); ?>
            </div>
        </div>
        <div class="row-fluid control-group">

            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'parent_id', $model->getParentList(), array('empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'condition_name', $model->getConditionList(),  array('empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'condition_denial', $model->getConditionDenialList(),  array('empty' => '---')); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('MenuModule.menu', 'Find menu item'),
    )); ?>

<?php $this->endWidget(); ?>
