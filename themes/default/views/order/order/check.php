<?php
/**
 * @var $this OrderController
 * @var $model Order
 */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->title = [Yii::t('OrderModule.order', 'Check order'), Yii::app()->getModule('yupe')->siteName];
?>


<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'          => 'check-order-form',
        'type'        => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
        ]
    ]
); ?>

<?= $form->errorSummary($model); ?>

<?php if($order):?>

    <div class="alert alert-success">
        <?= Yii::t('OrderModule.order', 'Status') ?>: <strong><?= $order->status->getTitle();?></strong>
    </div>

<?php elseif(!$model->hasErrors()): ?>

    <div class="alert alert-danger">
        <?= Yii::t('OrderModule.order', 'Order not found!') ?>
    </div>

<?php endif;?>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'number'); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'icon'        => 'glyphicon glyphicon-signin',
                'label'       => Yii::t('OrderModule.order', 'Check')
            ]
        ); ?>

    </div>
</div>


<?php $this->endWidget(); ?>
