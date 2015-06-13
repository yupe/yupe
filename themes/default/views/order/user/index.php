<?php
/* @var $orders Order[] */

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');

$this->title = Yii::t('OrderModule.order', 'Personal account');
?>

<h1><?= Yii::t('OrderModule.order', 'Orders history'); ?></h1>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th class="col-sm-3"><?= Yii::t("OrderModule.order", "Date");?></th>
            <th class="col-sm-7"><?= Yii::t("OrderModule.order", "Order #");?></th>
            <th class="col-sm-2"><?= Yii::t("OrderModule.order", "Status");?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ((array)$orders as $order): ?>
            <tr>
                <td>
                    <?= date('d.m.Y в H:i', strtotime($order->date)); ?>
                </td>
                <td>
                    <?= CHtml::link(
                            Yii::t('OrderModule.order', 'Order #{n}', [$order->id]),
                            ['/order/order/view', 'url' => $order->url]
                        ) . ($order->paid ? ' - ' . $order->getPaidStatus() : ''); ?>
                </td>
                <td>
                    <?= $order->status->getTitle(); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
