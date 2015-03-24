<?php
/**
 * @var $this TemplateBackendController
 * @var $model MailTemplate
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'mail-template-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('MailModule.mail', 'Fields, with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('MailModule.mail', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'event_id',
            [
                'widgetOptions' => [
                    'data'        => CHtml::listData(MailEvent::model()->findAll(), 'id', 'name'),
                    'htmlOptions' => ['empty' => Yii::t('MailModule.mail', '--choose--')],
                ],
            ]
        ); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->slugFieldGroup($model, 'code', ['sourceAttribute' => 'name']); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'from'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'to'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'theme'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'body'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'body',
            ]
        ); ?>
    </div>

</div>
<div class='row'>
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
    </div>

</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => [],
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
        'label'      => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create template and continue') : Yii::t(
            'MailModule.mail',
            'Save template and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create template and close') : Yii::t(
            'MailModule.mail',
            'Save template and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>
