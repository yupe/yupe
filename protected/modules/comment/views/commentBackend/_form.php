<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'comment-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?=  Yii::t('CommentModule.comment', 'Fields with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('CommentModule.comment', 'are require.'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'model'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'model_id'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'url'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-12">
        <?=  $form->labelEx($model, 'text'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'text',
            ]
        ); ?>
        <br/><?=  $form->error($model, 'text'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-2">
        <?=  $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and continue') : Yii::t(
                'CommentModule.comment',
                'Save comment and continue'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('CommentModule.comment', 'Create comment and close') : Yii::t(
                'CommentModule.comment',
                'Save comment and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
