<?php
/* @var $model Order */
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->pageTitle = Yii::t('OrderModule.order', 'Проверка заказа');
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
        Статус заказа: <strong><?= $order->getStatusTitle();?></strong>
    </div>

<?php elseif(!$model->hasErrors()): ?>

    <div class="alert alert-danger">
        Заказ не найден!
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
                'label'       => 'Проверить'
            ]
        ); ?>

    </div>
</div>


<?php $this->endWidget(); ?>
