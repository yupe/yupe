<?php
/* @var $model Order */
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->title = [Yii::t('OrderModule.order', 'Order #{n}', [$model->id]), Yii::app()->getModule('yupe')->siteName];
?>
<div class="row">
    <div class="col-sm-12">
        <h1><?= Yii::t("OrderModule.order", "Order #"); ?><?= $model->id; ?>
            <small>[<?= $model->status->getTitle(); ?>]</small>
        </h1>
        <table class="table">
            <tbody>
            <?php foreach ((array)$model->products as $position): ?>
                <tr>
                    <td class="col-sm-5">
                        <div class="media">
                            <?php $productUrl = Yii::app()->createUrl('/store/product/view', ['name' => $position->product->slug]); ?>
                            <a class="img-thumbnail pull-left" href="<?= $productUrl; ?>">
                                <img class="media-object" src="<?= $position->product->getImageUrl(72, 72); ?>">
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?= $productUrl; ?>"><?= CHtml::encode($position->product->name); ?></a>
                                </h4>
                                <?php foreach ($position->variantsArray as $variant): ?>
                                    <h6><?= $variant['attribute_title']; ?>: <?= $variant['optionValue']; ?></h6>
                                <?php endforeach; ?>
                                <span><?= Yii::t("OrderModule.order", "Status"); ?>:</span>
                                    <span class="text-<?= $position->product->isInStock() ? "success" : "warning"; ?>">
                                        <strong>
                                            <?= $position->product->isInStock() ? Yii::t("OrderModule.order", "In stock") : Yii::t("OrderModule.order", "Not in stock"); ?>
                                        </strong>
                                    </span>
                            </div>
                        </div>
                    </td>
                    <td class="col-sm-4">
                        <p class="text-right lead">
                            <strong>
                                <span class=""><?= $position->price; ?></span>
                                <?= Yii::t("OrderModule.order", "RUB"); ?>
                                ×
                                <?= $position->quantity; ?> <?= Yii::t("OrderModule.order", "PCs"); ?>
                            </strong>
                        </p>
                    </td>
                    <td class="col-sm-3 text-center">
                        <p class="text-right lead">
                            <strong>
                                <span
                                    class=""><?= $position->getTotalPrice(); ?></span> <?= Yii::t("OrderModule.order", "RUB"); ?>
                            </strong>
                        </p>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if ($model->hasCoupons()): ?>
                <tr>
                    <td colspan="2">
                        <h4><?= Yii::t("OrderModule.order", "Coupons"); ?></h4>
                    </td>
                    <td>
                        <?php foreach ($model->getCouponsCodes() as $code): ?>
                            <span class="label label-info coupon">
                                <?= CHtml::encode($code); ?>
                            </span>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="2">
                    <h4><?= Yii::t("OrderModule.order", "Total"); ?></h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong>
                            <small>
                                <?= $model->getTotalPrice(); ?>
                                <?= Yii::t("OrderModule.order", "RUB"); ?>
                            </small>
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4><?= Yii::t("OrderModule.order", "Delivery price"); ?>
                        <small>
                            <?= $model->separate_delivery ? Yii::t("OrderModule.order", '(paid separately)') : ''; ?>
                        </small>
                    </h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong>
                            <small><?= $model->getDeliveryPrice(); ?>  <?= Yii::t("OrderModule.order", "RUB"); ?></small>
                        </strong>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4><?= Yii::t("OrderModule.order", "Total"); ?></h4>
                </td>
                <td>
                    <p class="text-right lead">
                        <strong><?= $model->getTotalPriceWithDelivery(); ?></strong> <?= Yii::t("OrderModule.order", "RUB"); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">
                                <?= Yii::t("OrderModule.order", "Order details"); ?>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-sm-2">
                                <?= CHtml::activeLabel($model, 'date'); ?>
                            </td>
                            <td>
                                <?= $model->date; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2">
                                <?= CHtml::activeLabel($model, 'delivery_id'); ?>
                            </td>
                            <td>
                                <?php if (!empty($model->delivery)): ?>
                                    <?= CHtml::encode($model->delivery->name); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= CHtml::activeLabel($model, 'name'); ?>
                            </td>
                            <td>
                                <?= CHtml::encode($model->name); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= CHtml::activeLabel($model, 'phone'); ?>
                            </td>
                            <td>
                                <?= CHtml::encode($model->phone); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= CHtml::activeLabel($model, 'email'); ?>
                            </td>
                            <td>
                                <?= CHtml::encode($model->email); ?>
                            </td>
                        </tr>
                        <?php if ($model->getAddress()): ?>
                            <tr>
                                <td>
                                    <?= Yii::t("OrderModule.order", "Address"); ?>
                                </td>
                                <td>
                                    <?= CHtml::encode($model->getAddress()); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td>
                                <?= CHtml::activeLabel($model, 'comment'); ?>
                            </td>
                            <td>
                                <?= CHtml::encode($model->comment); ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            <?php if (!$model->isPaid() && !empty($model->delivery) && $model->delivery->hasPaymentMethods()): ?>
                <tr>
                    <td colspan="3">
                        <ul id="payment-methods">
                            <?php foreach ((array)$model->delivery->paymentMethods as $payment): ?>
                                <li class="payment-method">
                                    <div class="checkbox">
                                        <input class="payment-method-radio" type="radio" name="payment_method_id"
                                               value="<?= $payment->id; ?>" checked=""
                                               id="payment-<?= $payment->id; ?>">
                                    </div>
                                    <h3>
                                        <label
                                            for="payment-<?= $payment->id; ?>"><?= CHtml::encode($payment->name); ?></label>
                                    </h3>

                                    <div class="description">
                                        <?= $payment->description; ?>
                                    </div>
                                    <div class="payment-form hidden">
                                        <?= $payment->getPaymentForm($model); ?>
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
                                <?= Yii::t("OrderModule.order", "Pay"); ?>
                                <span class="glyphicon glyphicon-play"></span>
                            </button>
                        </p>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3">
                        <p class="text-right">
                            <span class="aler alert-warning"><?= $model->getPaidStatus(); ?></span>
                        </p>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
