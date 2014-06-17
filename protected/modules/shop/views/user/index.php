<?php /* @var $orders Order[] */
$this->pageTitle = Yii::t('ShopModule.user', 'Личный кабинет');
?>

<h1><?php echo Yii::t('ShopModule.user', 'История заказов'); ?></h1>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th class="span3">Дата</th>
        <th class="span7">Номер</th>
        <th class="span2">Статус</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ((array)$orders as $order): ?>
        <tr>
            <td>
                <?php echo date('d.m.Y в H:i', strtotime($order->date)); ?>
            </td>
            <td>
                <?php echo CHtml::link(Yii::t('ShopModule.order', 'Заказ №{n}', array($order->id)), array('/shop/order/view', 'url' => $order->url)) . ($order->paid ? ' - ' . $order->getPaidStatus() : ''); ?>
            </td>
            <td>
                <?php echo $order->getStatusTitle(); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>