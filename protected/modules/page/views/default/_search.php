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
                <?php echo $form->dropDownListRow($model, 'parent_id', $pages, array('empty' => Yii::t('PageModule.page', '- не выбрана -'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('empty' => Yii::t('PageModule.page', '- не важно -'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'creation_date'); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'change_date'); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'title', array('maxlength' => 150)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'title_short', array('maxlength' => 150)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'slug', array('maxlength' => 150)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'keywords', array('maxlength' => 150)); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'description', array('maxlength' => 250)); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('news', '- не важно -')), array('empty' => Yii::t('PageModule.page', '- не выбрана -'))); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span12">
                <?php echo $form->textFieldRow($model, 'body'); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
       'buttonType'  => 'submit',
       'type'        => 'primary',
       'encodeLabel' => false,
       'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('PageModule.page', 'Искать страницы'),
    )); ?>

<?php $this->endWidget(); ?>
