<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array( 'class' => 'well' ),
)); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span1">
                <?php echo $form->textFieldRow($model, 'id'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'name'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'code'); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'description'); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => Yii::t('menu', '--выберите значение--'))); ?>
            </div>
        </div>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'encodeLabel' => false,
            'label' => '<i class="icon-search icon-white"></i> '.Yii::t('menu', 'Искать')
         )); ?>
    </fieldset>
<?php $this->endWidget(); ?>