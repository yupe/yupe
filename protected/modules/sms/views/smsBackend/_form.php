<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'sms-send-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('SmsModule.sms', 'Fields, with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('SmsModule.sms', 'are required.'); ?>
    </div>

    <?php echo  $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'to'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'text'); ?>
        </div>
    </div>

<div class='controls'>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('SmsModule.sms','Send message and continue'),
        )
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'      => Yii::t('SmsModule.sms','Send message and close'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
