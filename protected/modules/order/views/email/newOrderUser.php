<?php
/* @var $order Order */;
$order->refresh();
?>
<html>
    <head>

    </head>
    <body>

        <?php $subject = Yii::t('OrderModule.order', 'Заказ №{n} в магазине {site}', array('{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName)); ?>
        <h1 style="font-weight:normal;">
            <?php echo CHtml::link("Ваш заказ №{$order->id}", Yii::app()->createAbsoluteUrl('/store/order/view', array('url' => $order->url))); ?>
            на сумму <?php echo Yii::t('OrderModule.order', '{n} рубль|{n} рубля|{n} рублей', array($order->total_price)); ?>
            <?php if ($order->paid): ?>
                оплачен,
            <?php else: ?>
                еще не оплачен,
            <?php endif; ?>
            <?php
            $status = array(0 => 'ждет обработки', 1 => 'в обработке', 2 => 'выполнен');
            echo $status[$order->status];
            ?>
        </h1>
        <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
            <tr>
                <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                    Статус
                </td>
                <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
                    <?php echo $status[$order->status];; ?>
                </td>
            </tr>
            <tr>
                <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                    Оплата
                </td>
                <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
                    <?php if ($order->paid): ?>
                        <font color="green">оплачен</font>
                    <?php else: ?>
                        еще не оплачен
                    <?php endif; ?>
                </td>
            </tr>
            <?php if ($order->name): ?>
                <tr>
                    <td style="padding:6px; width:170; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Имя, фамилия
                    </td>
                    <td style="padding:6px; width:330; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $order->name; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($order->email): ?>
                <tr>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Email
                    </td>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $order->email; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($order->phone): ?>
                <tr>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Телефон
                    </td>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $order->phone; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($order->address): ?>
                <tr>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Адрес доставки
                    </td>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $order->address; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php if ($order->comment): ?>
                <tr>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Комментарий
                    </td>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo nl2br($order->comment); ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                    Дата
                </td>
                <td style="padding:6px; width:170; background-color:#ffffff; border:1px solid #e0e0e0;">
                    <?php echo Yii::app()->getDateFormatter()->formatDateTime($order->date, "long", "short"); ?>
                </td>
            </tr>
        </table>

        <h1 style="font-weight:normal;">Вы заказали:</h1>

        <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">

            <?php foreach ($order->products as $orderProduct): ?>
                <?php $productUrl = Yii::app()->createAbsoluteUrl('/shop/catalog/show', array('name' => $orderProduct->product->alias)); ?>
                <tr>
                    <td align="center" style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php if ($orderProduct->product): ?>
                            <a href="<?php echo $productUrl; ?>">
                                <?php if ($orderProduct->product->mainImage): ?>
                                    <img border="0" src="<?php echo Yii::app()->getBaseUrl(true) . $orderProduct->product->mainImage->getImageUrl(50, 50); ?>">
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <?php echo $orderProduct->product_name; ?>
                        <?php endif; ?>
                    </td>
                    <td style="padding:6px; width:250; padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        <a href="<?php echo $productUrl; ?>"><?php echo $orderProduct->product_name; ?></a>
                        <?php foreach ($orderProduct->variantsArray as $variant): ?>
                            <h5><?php echo $variant['attribute_title']; ?>: <?php echo $variant['optionValue']; ?></h5>
                        <?php endforeach; ?>
                    </td>
                    <td align=right style="padding:6px; text-align:right; width:150; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $orderProduct->quantity; ?> шт. &times; <?php echo $orderProduct->price; ?>&nbsp; руб.
                    </td>
                </tr>
            <?php endforeach; ?>


            <?php if ($order->coupon_code): ?>
                <tr>
                    <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        Купон <?php echo $order->coupon_code; ?>
                    </td>
                    <td align=right style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;">
                        &minus;<?php echo $order->coupon_discount; ?>&nbsp;руб.
                    </td>
                </tr>
            <?php endif; ?>

            <?php if ($order->delivery && !$order->separate_delivery): ?>
                <tr>
                    <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
                    <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;">
                        <?php echo $order->delivery->name; ?>
                    </td>
                    <td align="right" style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;">
                        <?php echo $order->delivery_price; ?>&nbsp;руб.
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <td style="padding:6px; width:100; padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;"></td>
                <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-weight:bold;">
                    Итого
                </td>
                <td align="right" style="padding:6px; text-align:right; width:170; background-color:#ffffff; border:1px solid #e0e0e0;font-weight:bold;">
                    <?php echo $order->total_price; ?>&nbsp;руб.
                </td>
            </tr>
        </table>

        <br>
        Вы всегда можете проверить состояние заказа по ссылке:<br>
        <?php echo CHtml::link(Yii::app()->createAbsoluteUrl('/store/order/view', array('url' => $order->url)), Yii::app()->createAbsoluteUrl('/store/order/view', array('url' => $order->url))); ?>
        <br>

    </body>
</html>
