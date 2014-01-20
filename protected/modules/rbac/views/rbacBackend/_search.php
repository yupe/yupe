<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)); ?>

<?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'span5')); ?>

<?php echo $form->textAreaRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'label' => Yii::t('RbacModule.rbac','Искать'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
