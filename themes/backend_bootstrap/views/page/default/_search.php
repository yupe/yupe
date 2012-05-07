    <?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
                                                         'action' => Yii::app()->createUrl($this->route),
                                                         'method' => 'get',
                                                         'htmlOptions'=> array( 'class' => 'well' ),
                                                    )); ?>
    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'parent_Id', $pages, array('empty'=>Yii::t('page','- не выбрана -'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(),  array('empty'=>Yii::t('page','- не важно -'))); ?>
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
            <div class="span12">
                <?php echo $form->textFieldRow($model, 'body'); ?>
            </div>
        </div>
        <?php $this->widget('bootstrap.widgets.BootButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'encodeLabel' => false,
            'label' => '<i class="icon-search icon-white"></i> '.Yii::t('page', 'Искать')
        )); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
