<html>
<head>
</head>
<body>
<h1 style="font-weight:normal;">
    Ваш заказ на сумму <?= Yii::t('OrderModule.order', '{n} рубль|{n} рубля|{n} рублей', [$order->getTotalPrice()]);?> в магазине "<?= Yii::app()->getModule('yupe')->siteName;?>".
</h1>
<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
    <tr>
        <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
            Статус
        </td>
        <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
            <?= $order->status->getTitle(); ?>
        </td>
    </tr>
    <tr>
        <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
            Оплата
        </td>
        <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
            <?= $order->getPaidStatus(); ?>
        </td>
    </tr>
    <?php if ($order->name): ?>
        <tr>
            <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Имя, фамилия
            </td>
            <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= CHtml::encode($order->name); ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($order->email): ?>
        <tr>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Email
            </td>
            <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= CHtml::encode($order->email); ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($order->phone): ?>
        <tr>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Телефон
            </td>
            <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= CHtml::encode($order->phone); ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($order->getAddress()): ?>
        <tr>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Адрес доставки
            </td>
            <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= CHtml::encode($order->getAddress()); ?>
            </td>
        </tr>
    <?php endif; ?>
    <?php if ($order->comment): ?>
        <tr>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Комментарий
            </td>
            <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= nl2br(CHtml::encode($order->comment)); ?>
            </td>
        </tr>
    <?php endif; ?>
</table>

<h1 style="font-weight:normal;">Покупатель заказал:</h1>

<table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">

    <?php foreach ($order->products as $orderProduct): ?>
        <?php $productUrl = Yii::app()->createAbsoluteUrl(
            '/store/product/view',
            ['name' => $orderProduct->product->slug]
        ); ?>
        <tr>
            <td align="center"
                style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?php if ($orderProduct->product): ?>
                    <a href="<?= $productUrl; ?>">
                        <?php if ($orderProduct->product->image): ?>
                            <img border="0" src="<?= Yii::app()->getBaseUrl(true) . $orderProduct->product->getImageUrl(
                                50,
                                50
                            ); ?>">
                        <?php endif; ?>
                    </a>
                <?php else: ?>
                    <?= CHtml::encode($orderProduct->product_name); ?>
                <?php endif; ?>
            </td>
            <td style="padding:6px; width:250; padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                <a href="<?= $productUrl; ?>"><?= $orderProduct->product_name; ?></a>
                <?php foreach ($orderProduct->variantsArray as $variant): ?>
                    <h5><?= $variant['attribute_title']; ?>: <?= $variant['optionValue']; ?></h5>
                <?php endforeach; ?>
            </td>
            <td align=right
                style="padding:6px; text-align:right; width:150; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= $orderProduct->quantity; ?> шт. &times; <?= $orderProduct->price; ?>&nbsp; руб.
            </td>
        </tr>
    <?php endforeach; ?>


    <?php if ($order->hasCoupons()): ?>
        <tr>
            <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                Купон <?= CHtml::encode(implode(', ', $order->getCouponsCodes())); ?>
            </td>
            <td align=right
                style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;">
                &minus;<?= $order->coupon_discount; ?>&nbsp;руб.
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($order->delivery && !$order->separate_delivery): ?>
        <tr>
            <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
            <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                <?= CHtml::encode($order->delivery->name); ?>
            </td>
            <td align="right"
                style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;">
                <?= $order->getDeliveryPrice(); ?>&nbsp;руб.
            </td>
        </tr>
    <?php endif; ?>

    <tr>
        <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
        <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-weight:bold;">
            Итого
        </td>
        <td align="right"
            style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-weight:bold;">
            <?= $order->getTotalPriceWithDelivery(); ?>&nbsp;руб.
        </td>
    </tr>
</table>

<br>
Вы всегда можете проверить состояние заказа по ссылке:<br>
<?= CHtml::link(
    Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url]),
    Yii::app()->createAbsoluteUrl('/order/order/view', ['url' => $order->url])
); ?>
<br>

</body>
</html>
