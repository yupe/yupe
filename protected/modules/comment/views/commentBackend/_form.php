<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'comment-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('CommentModule.comment', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('CommentModule.comment', 'are require.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'model'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'model_id'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'url'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'text',
            )
        ); ?>
        <br/><?php echo $form->error($model, 'text'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data' => $model->getStatusList(),
                ),
            )
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and continue') : Yii::t(
                'CommentModule.comment',
                'Save comment and continue'
            ),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and close') : Yii::t(
                'CommentModule.comment',
                'Save comment and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
