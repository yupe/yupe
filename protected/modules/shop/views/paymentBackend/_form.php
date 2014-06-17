<?php
/* @var $model Payment */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'payment-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
        'inlineErrors' => true,
    )
);
?>

    <div class="alert alert-info">
        <?php echo Yii::t('ShopModule.payment', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ShopModule.payment', 'обязательны.'); ?>
    </div>

<?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo ($model->hasErrors('name') || $model->hasErrors('name')) ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'size' => 60, 'maxlength' => 250)); ?>
    </div>
    <div class="row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('status')) ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '')); ?>
    </div>

    <div class="row-fluid control-group <?php echo ($model->hasErrors('module') || $model->hasErrors('module')) ? 'error' : ''; ?>">
        <?php $paymentManager = new PaymentManager(); ?>
        <?php echo $form->dropDownListRow($model, 'module', $paymentManager->getSystemsFormattedList(), array('id' => 'payment-system', 'empty' => 'Ручная обработка')); ?>
        <div class="row-fluid">
            <div class="span6 panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">Настройки платежной системы</span>
                </div>
                <div class="panel-body form-horizontal" id="payment-system-settings">
                    <?php $this->renderPartial('_payment_system_settings', array(
                        'model' => $model,
                        'paymentManager' => $paymentManager,
                        //'paymentSystem' => $model->module,
                        //'paymentSettings' => $model->getPaymentSystemSettings()
                    )); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#payment-system').change(function () {
                    var module = this.value;
                    if (module) {
                        $.ajax({
                            url: '<?php echo Yii::app()->createUrl('/shop/paymentBackend/paymentSystemSettings')?>',
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
    </div>
<?php if (!$model->isNewRecord && $model->module): ?>
    <div class="row-fluid">
        <?php echo CHtml::label('Ссылка для HTTP уведомлений платежной системы', ''); ?>
        <?php echo CHtml::textField('PaymentProcessUrl', Yii::app()->createAbsoluteUrl('/shop/payment/process', array('id' => $model->id)), array('class' => 'span6', 'disabled' => true)) ?>
    </div>
<?php endif; ?>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget($this->module->editor, array(
            'model' => $model,
            'attribute' => 'description',
            'options' => $this->module->editorOptions,
        )); ?>
    </div>
<?php echo $form->hiddenField($model, 'position'); ?>

    <br/><br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => Yii::t('ShopModule.payment', 'Сохранить и продолжить'),
    ));
?>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => Yii::t('ShopModule.payment', 'Сохранить и вернуться к списку'),
    ));
?>

<?php $this->endWidget(); ?>