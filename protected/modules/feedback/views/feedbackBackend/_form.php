<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'feedback-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'action'                 => $model->isNewRecord ? array('create') : array('update', 'id' => $model->id),
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('FeedbackModule.feedback', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('FeedbackModule.feedback', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('type') || $model->hasErrors('status')) ? 'error' : ''; ?>">
        <div class="span6">
            <?php echo $form->dropDownListRow($model, 'type', Yii::app()->getModule('feedback')->types, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
        </div>
        <div class="span6">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model,'category_id',Category::model()->getFormattedList((int)Yii::app()->getModule('feedback')->mainCategory), array('empty' => Yii::t('FeedbackModule.feedback','--choose--'),'class' => 'popover-help span12', 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help span12', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('email') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'popover-help span12', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('email'), 'data-content' => $model->getAttributeDescription('email'))); ?>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('phone') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'phone', array('class' => 'popover-help span12', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('phone'), 'data-content' => $model->getAttributeDescription('phone'))); ?>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('theme') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'theme', array('class' => 'popover-help span12', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('theme'), 'data-content' => $model->getAttributeDescription('theme'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('text'); ?>' data-content='<?php echo $model->getAttributeDescription('text'); ?>'>
            <?php $this->widget($this->module->editor, array(
                'id'          => substr(md5(microtime()), 0, 7),
                'model'       => $model,
                'attribute'   => 'text',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'text'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('answer') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('answer'); ?>' data-content='<?php echo $model->getAttributeDescription('answer'); ?>'>
            <?php echo $form->labelEx($model, 'answer'); ?>
            <?php $this->widget($this->module->editor, array(
                'id'          => substr(md5(microtime()), 0, 7),
                'model'       => $model,
                'attribute'   => 'answer',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'answer'); ?>
        </div>
    </div>
    <div class="row-fluid control-group  <?php echo $model->hasErrors('is_faq') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'is_faq', array('class' => 'popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('is_faq'), 'data-content' => $model->getAttributeDescription('is_faq'))); ?>
    </div>
    <?php if ($model->status == FeedBack::STATUS_ANSWER_SENDED): ?>
        <div class="row-fluid control-group">
            <div class="span7">
                <label><?php echo Yii::t('FeedbackModule.feedback', 'Ответил'); ?> <?php echo CHtml::link($model->getAnsweredUser()->nick_name, array( '/user/userBackend/view', 'id' => $model->answer_user )); ?> (<?php echo $model->answer_date; ?>)</label>
                <?php echo $model->answer; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class='controls'>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('FeedbackModule.feedback', 'Create message and continue') : Yii::t('FeedbackModule.feedback', 'Save message and continue'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => $model->isNewRecord ? Yii::t('FeedbackModule.feedback', 'Create message and close') : Yii::t('FeedbackModule.feedback', 'Save message and close'),
        )); ?>
    </div>

<?php $this->endWidget(); ?>
