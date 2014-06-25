<?php /* @var $model Order */
$this->pageTitle = Yii::t('ShopModule.order', 'Заказ №{n}', array($model->id));
?>
<div class="row-fluid">
    <div class="span12">
        <h1>Заказ №<?php echo $model->id; ?>
            <small>[<?php echo $model->getStatusTitle(); ?>]</small>
        </h1>
        <table class="table">
            <tbody>
            <?php foreach ((array)$model->products as $position): ?>
                <tr>
                    <td class="span5">
                        <div class="media">
                            <?php $productUrl = Yii::app()->createUrl('shop/catalog/show', array('name' => $position->product->alias)); ?>
                            <a class="thumbnail pull-left" href="<?php echo $productUrl; ?>">
                                <img class="media-object" src="<?php echo $position->product->mainImage->getImageUrl(72, 72); ?>" style="width: 72px; height: 72px;">
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?php echo $productUrl; ?>"><?php echo $position->product->name; ?></a>
                                </h4>
                                <?php foreach ($position->variantsArray as $variant): ?>
                                    <h6><?php echo $variant['attribute_title']; ?>: <?php echo $variant['optionValue']; ?></h6>
                                <?php endforeach; ?>
                                <span>Статус: </span><span class="text-<?php echo $position->product->in_stock ? "success" : "warning"; ?>"><strong><?php echo $position->product->in_stock ? "В наличии" : "Нет в наличии"; ?></strong></span>
                            </div>
                        </div>
                    </td>
                    <td class="span4">
                        <p class="text-right lead">
                            <strong>
                                <span class=""><?php echo $position->price; ?></span> руб. × <?php echo $position->quantity; ?> шт.
                            </strong>
                        </p>
                    </td>
                    <td class="span3 text-center">
                        <p class="text-right lead">
                            <strong>
                                <span class=""><?php echo (float)($position->price * $position->quantity); ?></span> руб.
                            </strong>
                        </p>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2">
                    <h4>Итого</h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong>
                            <small><?php echo (float)$model->total_price; ?> руб.</small>
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>Стоимость доставки</h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong>
                            <small><?php echo (float)$model->delivery_price; ?>  руб.</small>
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>Всего</h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong><?php echo (float)($model->total_price + $model->delivery_price); ?></strong> руб.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table table-condensed table-bordered table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">
                                Детали заказа
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="span2">
                                <?php echo CHtml::activeLabel($model, 'date'); ?>
                            </td>
                            <td>
                                <?php echo $model->date; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="span2">
                                <?php echo CHtml::activeLabel($model, 'delivery_id'); ?>
                            </td>
                            <td>
                                <?php echo $model->delivery->name; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeLabel($model, 'name'); ?>
                            </td>
                            <td>
                                <?php echo $model->name; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeLabel($model, 'phone'); ?>
                            </td>
                            <td>
                                <?php echo $model->phone; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeLabel($model, 'email'); ?>
                            </td>
                            <td>
                                <?php echo $model->email; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeLabel($model, 'address'); ?>
                            </td>
                            <td>
                                <?php echo $model->address; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo CHtml::activeLabel($model, 'comment'); ?>
                            </td>
                            <td>
                                <?php echo $model->comment; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            <?php if (!$model->paid): ?>
                <tr>
                    <td colspan="3">
                        <ul id="payment-methods">
                            <?php $paymentManager = new PaymentManager(); ?>
                            <?php foreach ((array)$model->delivery->paymentMethods as $payment): ?>
                                <li class="payment-method">
                                    <div class="checkbox">
                                        <input class="payment-method-radio" type="radio" name="payment_method_id" value="<?php echo $payment->id; ?>" checked="" id="payment-<?php echo $payment->id; ?>">
                                    </div>
                                    <h3>
                                        <label for="payment-<?php echo $payment->id; ?>"><?php echo $payment->name; ?></label>
                                    </h3>

                                    <div class="description">
                                        <?php echo $payment->description; ?>
                                    </div>
                                    <div class="payment-form hidden">
                                        <?php
                                        $paymentSystem = $paymentManager->loadPaymentSystemObject($payment->module);
                                        echo $paymentSystem ? $paymentSystem->renderCheckoutForm($payment, $model, true) : "";?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p class="text-right">
                            <button type="submit" class="btn btn-success" id="start-payment">
                                Оплатить <span class="icon-play"></span>
                            </button>
                        </p>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3">
                        <p class="text-right">
                            <?php echo $model->getPaidStatus() . ' - ' . date('d.m.Y в H:i', strtotime($model->payment_date)); ?>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>