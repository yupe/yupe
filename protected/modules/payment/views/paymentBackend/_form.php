<?php
/* @var $model Payment */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'payment-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
    )
);
?>

<div class="alert alert-info">
    <?php echo Yii::t('PaymentModule.payment', 'Поля, отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('PaymentModule.payment', 'обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
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
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'module',
            array(
                'widgetOptions' => array(
                    'data' => Yii::app()->paymentManager->getSystemsFormattedList(),
                    'htmlOptions' => array(
                        'id' => 'payment-system',
                        'empty' => Yii::t("PaymentModule.payment", 'Ручная обработка'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row" id="payment-system-settings-row" style="display: none;">
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title"><?php echo Yii::t("PaymentModule.payment", "Настройки платежной системы"); ?></span>
            </div>
            <div class="panel-body" id="payment-system-settings">
                <?php $this->renderPartial(
                    '_payment_system_settings',
                    array(
                        'paymentSystem' => $model->module,
                        'paymentSettings' => $model->getPaymentSystemSettings(),
                    )
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
                    url: '<?php echo Yii::app()->createUrl('/payment/paymentBackend/paymentSystemSettings')?>',
                    type: 'get',
                    data: {
                        payment_id: <?php echo $model->id ?: '""'?>,
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
                <?php echo CHtml::label(Yii::t("PaymentModule.payment", 'Ссылка для HTTP уведомлений платежной системы'), null, array('class' => 'control-label')); ?>
                <?php echo CHtml::textField(
                    'PaymentProcessUrl',
                    Yii::app()->createAbsoluteUrl('/payment/payment/process', array('id' => $model->id)),
                    array('disabled' => true, 'class' => 'form-control')
                ) ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class='row'>
    <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model' => $model,
                'attribute' => 'description',
            )
        ); ?>
        <p class="help-block"></p>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<?php echo $form->hiddenField($model, 'position'); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('PaymentModule.payment', 'Сохранить и продолжить'),
    )
);
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('PaymentModule.payment', 'Сохранить и вернуться к списку'),
    )
);
?>

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
