<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span1">
                <?php echo $form->textFieldRow($model, 'id'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'creation_date'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'change_date'); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'first_name', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'last_name', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'nick_name', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'gender', $model->getGendersList()); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'access_level', $model->getAccessLevelsList()); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'last_visit'); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'registration_date'); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'registration_ip', array('size' => 20, 'maxlength' => 20)); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'activation_ip', array('size' => 20, 'maxlength' => 20)); ?>
            </div>
        </div>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'type'        => 'primary',
            'encodeLabel' => false,
            'label'       => '<i class="icon-search icon-white"></i> '.Yii::t('user', 'Искать'),
        )); ?>
</fieldset>

<?php $this->endWidget(); ?>