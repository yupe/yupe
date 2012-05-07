<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions'=> array( 'class' => 'well' ),
)); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span1">
                <?php echo $form->textFieldRow($model, 'id'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'date'); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(),array('empty' => Yii::t('news','- не важен -'))); ?>
            </div>
            <div class="span6"><br />
                <?php echo $form->checkBoxRow($model, 'is_protected', $model->getProtectedStatusList()); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span6">
                <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span6">
                <?php echo $form->textFieldRow($model, 'alias', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span6">
                <?php echo $form->textFieldRow($model, 'short_text', array('size' => 60, 'maxlength' => 400)); ?>
            </div>
            <div class="span6">
                <?php echo $form->textFieldRow($model, 'full_text'); ?>
            </div>
        </div>
        <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'encodeLabel' => false,
        'label' => '<i class="icon-search icon-white"></i> '.Yii::t('news', 'Искать')
        )); ?>

    </fieldset>
    <?php $this->endWidget(); ?>

