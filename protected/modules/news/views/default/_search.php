<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well form-vertical'),
)); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'id'); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'date'); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('empty' => Yii::t('NewsModule.news', '- не важен -'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->categoryList, 'id', 'name'), array('empty' => Yii::t('NewsModule.news', '- не важно -'))); ?>
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
            <div class="span10">
                <?php echo $form->checkBoxRow($model, 'is_protected', $model->protectedStatusList); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('blog', 'Искать новость'),
    )); ?>

<?php $this->endWidget(); ?>
