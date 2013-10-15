<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset>
        <?php echo $form->textFieldRow($model, 'id') ?>
        <?php echo $form->textFieldRow($model, 'title'); ?>
        <?php echo $form->textFieldRow($model, 'href'); ?>
        <?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('MenuModule.menu', 'choose menu'))); ?>
        <?php echo $form->dropDownListRow($model, 'parent_id', $model->parentList); ?>
        <?php echo $form->dropDownListRow($model, 'condition_name', $model->conditionList); ?>
        <?php echo $form->dropDownListRow($model, 'condition_denial', $model->conditionDenialList); ?>
        <?php echo $form->textFieldRow($model, 'sort'); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList); ?>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('MenuModule.menu', 'Find menu item'),
    )); ?>

<?php $this->endWidget(); ?>
