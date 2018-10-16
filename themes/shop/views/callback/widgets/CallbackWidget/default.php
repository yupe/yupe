<?php
/**
 * @var Callback $model
 * @var string $phoneMask
 * @var CActiveForm $form
 */
?>
<a href="javascript:void(0);" data-toggle="#callback-request" class="header-phone-callback" id="callback-link">
    <?= Yii::t('CallbackModule.callback', 'Request a call back') ?>
</a>

<div id="callback-request" class="callback-request">
    <div class="grid">
        <div class="grid-module-3">
            <?php $form = $this->beginWidget('CActiveForm', [
                'id' => 'callback-form',
                'action' => Yii::app()->createUrl('/callback/callback/send'),
                'enableClientValidation' => true,
                'clientOptions' => [
                    'validateOnSubmit' => true,
                    'afterValidate' => 'js:callbackSendForm',
                ],
            ]); ?>

            <?= $form->errorSummary($model); ?>

                <div class="fast-order__inputs">
                    <?= $form->labelEx($model, 'name'); ?>
                    <?= $form->textField($model, 'name', ['class' => 'input input_big']); ?>
                    <?= $form->error($model, 'name') ?>
                </div>

                <div class="fast-order__inputs">
                    <div class="column grid-module-2">
                        <?= $form->labelEx($model, 'phone'); ?>
                        <?php $this->widget('CMaskedTextField', [
                            'model' => $model,
                            'attribute' => 'phone',
                            'mask' => $phoneMask,
                            'htmlOptions' => [
                                'class' => 'input input_big'
                            ]
                        ]); ?>
                        <?= $form->error($model, 'phone') ?>
                    </div>
                    <div class="column grid-module-1 pull-right">
                        <?= $form->labelEx($model, 'time'); ?>
                        <?php $this->widget('CMaskedTextField', [
                            'model' => $model,
                            'attribute' => 'time',
                            'mask' => 'H9:M9',
                            'charMap' => [
                                'H' => '[0-2]',
                                'M' => '[0-5]',
                                '9' => '[0-9]'
                            ],
                            'htmlOptions' => [
                                'class' => 'input input_big'
                            ]
                        ]); ?>
                        <?= $form->error($model, 'time') ?>
                    </div>
                </div>

                <div class="fast-order__inputs">
                    <button type="submit" class="btn btn_big btn_primary" id="callback-send">
                        <?= Yii::t('CallbackModule.callback', 'Send request') ?>
                    </button>
                    <button type="button" class="btn btn_big btn_white" data-toggle="#callback-request">
                        <?= Yii::t('CallbackModule.callback', 'Close') ?>
                    </button>
                </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
