<?php
/**
 * Отображение для _form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 *
 * @var $this EventBackendController
 * @var $model MailEvent
 * @var $form \yupe\widgets\ActiveForm
 **/
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'mail-event-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>

<div class="alert alert-info">
    <?=  Yii::t('MailModule.mail', 'Fields, with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('MailModule.mail', 'are required.'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->slugFieldGroup($model, 'code', ['sourceAttribute' => 'name']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?=  $form->textAreaGroup($model, 'description'); ?>
    </div>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create event and continue') : Yii::t(
            'MailModule.mail',
            'Save event and continue'
        ),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create event and close') : Yii::t(
            'MailModule.mail',
            'Save event and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>
