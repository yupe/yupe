<?php
/* @var $model Payment */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'payment-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well']
    ]
);
?>

<div class="alert alert-info">
    <?= Yii::t('PaymentModule.payment', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('PaymentModule.payment', 'are required'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?=  $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?=  $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList()
                ]
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?=  $form->dropDownListGroup(
            $model,
            'module',
            [
                'widgetOptions' => [
                    'data' => Yii::app()->paymentManager->getSystemsFormattedList(),
                    'htmlOptions' => [
                        'id' => 'payment-system'
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row" id="payment-system-settings-row" style="display: none;">
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title"><?=  Yii::t("PaymentModule.payment", "Payment system settings"); ?></span>
            </div>
            <div class="panel-body" id="payment-system-settings">
                <?php $this->renderPartial(
                    '_payment_system_settings',
                    [
                        'paymentSystem' => $model->module,
                        'paymentSettings' => $model->getPaymentSystemSettings()
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#payment-system').change(function () {
            var module = this.value;
            if (module) {
                $.ajax({
                    url: '<?=  Yii::app()->createUrl('/payment/paymentBackend/paymentSystemSettings')?>',
                    type: 'get',
                    data: {
                        payment_id: <?=  $model->id ?: '""'?>,
                        payment_system: module
                    },
                    success: function (data) {
                        $('#payment-system-settings').html(data);
                    }
                })
            }
            else {
                $('#payment-system-settings').html('');
            }
        })
    })
</script>

<?php if (!$model->isNewRecord && $model->module): ?>
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <?=  CHtml::label(Yii::t("PaymentModule.payment", 'Payment system notifications HTTP link'), null, ['class' => 'control-label']); ?>
                <?=  CHtml::textField(
                    'PaymentProcessUrl',
                    Yii::app()->createAbsoluteUrl('/payment/payment/process', ['id' => $model->id]),
                    ['disabled' => true, 'class' => 'form-control']
                ) ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class='row'>
    <div class="col-sm-12 <?=  $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?=  $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model' => $model,
                'attribute' => 'description'
            ]
        ); ?>
        <p class="help-block"></p>
        <?=  $form->error($model, 'description'); ?>
    </div>
</div>
<?=  $form->hiddenField($model, 'position'); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('PaymentModule.payment', 'Add payment and continue') : Yii::t('PaymentModule.payment', 'Save payment and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('PaymentModule.payment', 'Add payment and close') : Yii::t('PaymentModule.payment', 'Save payment and close'),
    ]
); ?>


<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#payment-system').on('change', function(){
            if($(this).val()) {
                $('#payment-system-settings-row').show();
            }else{
                $('#payment-system-settings-row').hide();
            }
        });
        if($('#payment-system').val()) {
            $('#payment-system-settings-row').show();
        }
    });

</script>
