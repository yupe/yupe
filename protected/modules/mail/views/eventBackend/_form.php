<script type='text/javascript'>
    $(document).ready(function () {
        $('#mail-event-form').liTranslit({
            elName: '#MailEvent_name',
            elAlias: '#MailEvent_code'
        });
    })
</script>

<?php
/**
 * Отображение для _form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'mail-event-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('MailModule.mail', 'Fields, with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('MailModule.mail', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'code'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textAreaGroup($model, 'description'); ?>
    </div>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create event and continue') : Yii::t(
                'MailModule.mail',
                'Save event and continue'
            ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('MailModule.mail', 'Create event and close') : Yii::t(
                'MailModule.mail',
                'Save event and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
