<?php
/* @var $model Order */
Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/order-frontend.css');

$this->pageTitle = Yii::t('OrderModule.order', 'Заказ №{n}', array($model->id));
?>
<div class="row">
    <div class="col-sm-12">
        <h1><?php echo Yii::t("OrderModule.order", "Заказ №"); ?><?php echo $model->id; ?>
            <small>[<?php echo $model->getStatusTitle(); ?>]</small>
        </h1>
        <table class="table">
            <tbody>
                <?php foreach ((array)$model->products as $position): ?>
                    <tr>
                        <td class="col-sm-5">
                            <div class="media">
                                <?php $productUrl = Yii::app()->createUrl('store/catalog/show', array('name' => $position->product->alias)); ?>
                                <a class="img-thumbnail pull-left" href="<?php echo $productUrl; ?>">
                                    <img class="media-object" src="<?php echo $position->product->image ? $position->product->getImageUrl(72, 72) : ''; ?>" style="width: 72px; height: 72px;">
                                </a>

                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?php echo $productUrl; ?>"><?php echo $position->product->name; ?></a>
                                    </h4>
                                    <?php foreach ($position->variantsArray as $variant): ?>
                                        <h6><?php echo $variant['attribute_title']; ?>: <?php echo $variant['optionValue']; ?></h6>
                                    <?php endforeach; ?>
                                    <span><?php echo Yii::t("OrderModule.order", "Статус"); ?>:</span>
                                    <span class="text-<?php echo $position->product->in_stock ? "success" : "warning"; ?>">
                                        <strong>
                                            <?php echo $position->product->in_stock ? Yii::t("OrderModule.order", "В наличии") : Yii::t("OrderModule.order", "Нет в наличии"); ?>
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-4">
                            <p class="text-right lead">
                                <strong>
                                    <span class=""><?php echo $position->price; ?></span>
                                    <?php echo Yii::t("OrderModule.order", "руб."); ?>
                                    ×
                                    <?php echo $position->quantity; ?> <?php echo Yii::t("OrderModule.order", "шт."); ?>
                                </strong>
                            </p>
                        </td>
                        <td class="col-sm-3 text-center">
                            <p class="text-right lead">
                                <strong>
                                    <span class=""><?php echo (float)($position->price * $position->quantity); ?></span> <?php echo Yii::t("OrderModule.order", "руб."); ?>
                                </strong>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <h4><?php echo Yii::t("OrderModule.order", "Купоны"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <?php if ($model->coupon_code): ?>
                                <?php foreach ($model->couponCodes as $code): ?>
                                    <span class="label alert alert-info coupon">
                                        <?php echo $code; ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?php echo Yii::t("OrderModule.order", "Итого"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong>
                                <small>
                                    <?php echo (float)$model->total_price - ($model->separate_delivery ? 0 : $model->delivery_price); ?>
                                    <?php echo Yii::t("OrderModule.order", "руб."); ?>
                                </small>
                            </strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?php echo Yii::t("OrderModule.order", "Стоимость доставки"); ?>
                            <small>
                                <?php echo($model->separate_delivery ? Yii::t("OrderModule.order", '(оплачивается отдельно)') : ''); ?>
                            </small>
                        </h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong>
                                <small><?php echo (float)$model->delivery_price; ?>  <?php echo Yii::t("OrderModule.order", "руб."); ?></small>
                            </strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?php echo Yii::t("OrderModule.order", "Всего"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong><?php echo (float)($model->total_price); ?></strong> <?php echo Yii::t("OrderModule.order", "руб."); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <?php echo Yii::t("OrderModule.order", "Детали заказа"); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-sm-2">
                                        <?php echo CHtml::activeLabel($model, 'date'); ?>
                                    </td>
                                    <td>
                                        <?php echo $model->date; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2">
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
                                <?php $paymentManager = Yii::app()->paymentManager; ?>
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
                                            $paymentSystem = $paymentManager->getPaymentSystemObject($payment->module);
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
                                    <?php echo Yii::t("OrderModule.order", "Оплатить"); ?>
                                    <span class="glyphicon glyphicon-play"></span>
                                </button>
                            </p>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="3">
                            <p class="text-right">
                                <?php echo $model->getPaidStatus() . ' - ' . date('d.m.Y H:i', strtotime($model->payment_date)); ?>
                            </p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
