<?php
/**
 * @var $this OrderController
 * @var $model Order
 * @var $form CActiveForm
 */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->title = [Yii::t('OrderModule.order', 'Check order'), Yii::app()->getModule('yupe')->siteName];
?>

<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('OrderModule.order', 'Check order') ?></h1>
</div>

<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'check-order-form',
        ]); ?>

            <?= $form->errorSummary($model); ?>

            <?php if ($order): ?>
                <div class="text-success">
                    <?= Yii::t('OrderModule.order', 'Status') ?>: <strong><?= $order->status->getTitle(); ?></strong>
                </div>
            <?php elseif (!$model->hasErrors()): ?>
                <div class="text-error">
                    <?= Yii::t('OrderModule.order', 'Order not found!') ?>
                </div>
            <?php endif; ?>

            <div class="fast-order__inputs">
                <div class="column grid-module-4">
                    <?= $form->textField($model, 'number', ['class' => 'input input_big', 'placeholder' => $model->getAttributeLabel('number')]); ?>
                    <?= $form->error($model, 'number') ?>
                </div>
                <div class="column grid-module-2 pull-right">
                    <button type="submit" class="btn btn_big btn_primary">
                        <?= Yii::t('OrderModule.order', 'Check') ?>
                        <span class="fa fa-fw fa-play"></span>
                    </button>
                </div>
            </div>
        <?php $this->endWidget(); ?>
    </div>
</div>