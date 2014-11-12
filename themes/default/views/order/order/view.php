<?php
/* @var $model Order */
$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

$this->pageTitle = Yii::t('OrderModule.order', 'Заказ №{n}', array($model->id));
?>
<div class="row">
    <div class="col-sm-12">
        <h1><?= Yii::t("OrderModule.order", "Заказ №"); ?><?= $model->id; ?>
            <small>[<?= $model->getStatusTitle(); ?>]</small>
        </h1>
        <table class="table">
            <tbody>
                <?php foreach ((array)$model->products as $position): ?>
                    <tr>
                        <td class="col-sm-5">
                            <div class="media">
                                <?php $productUrl = Yii::app()->createUrl('store/catalog/show', array('name' => $position->product->alias)); ?>
                                <a class="img-thumbnail pull-left" href="<?= $productUrl; ?>">
                                    <img class="media-object" src="<?= $position->product->getImageUrl(72, 72); ?>" style="width: 72px; height: 72px;">
                                </a>

                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?= $productUrl; ?>"><?= CHtml::encode($position->product->name); ?></a>
                                    </h4>
                                    <?php foreach ($position->variantsArray as $variant): ?>
                                        <h6><?= $variant['attribute_title']; ?>: <?= $variant['optionValue']; ?></h6>
                                    <?php endforeach; ?>
                                    <span><?= Yii::t("OrderModule.order", "Статус"); ?>:</span>
                                    <span class="text-<?= $position->product->isInStock() ? "success" : "warning"; ?>">
                                        <strong>
                                            <?= $position->product->isInStock() ? Yii::t("OrderModule.order", "В наличии") : Yii::t("OrderModule.order", "Нет в наличии"); ?>
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="col-sm-4">
                            <p class="text-right lead">
                                <strong>
                                    <span class=""><?= $position->price; ?></span>
                                    <?= Yii::t("OrderModule.order", "руб."); ?>
                                    ×
                                    <?= $position->quantity; ?> <?= Yii::t("OrderModule.order", "шт."); ?>
                                </strong>
                            </p>
                        </td>
                        <td class="col-sm-3 text-center">
                            <p class="text-right lead">
                                <strong>
                                    <span class=""><?= $position->getTotalPrice(); ?></span> <?= Yii::t("OrderModule.order", "руб."); ?>
                                </strong>
                            </p>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if($model->hasCoupon()):?>
                <tr>
                    <td colspan="2">
                        <h4><?= Yii::t("OrderModule.order", "Купоны"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <?php foreach ($model->getCoupons() as $code): ?>
                                <span class="label alert alert-info coupon">
                                    <?= CHtml::encode($code); ?>
                                </span>
                            <?php endforeach; ?>
                        </p>
                    </td>
                </tr>
                <?php endif;?>
                <tr>
                    <td colspan="2">
                        <h4><?= Yii::t("OrderModule.order", "Итого"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong>
                                <small>
                                    <?= $model->getTotalPrice(); ?>
                                    <?= Yii::t("OrderModule.order", "руб."); ?>
                                </small>
                            </strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?= Yii::t("OrderModule.order", "Стоимость доставки"); ?>
                            <small>
                                <?= $model->separate_delivery ? Yii::t("OrderModule.order", '(оплачивается отдельно)') : ''; ?>
                            </small>
                        </h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong>
                                <small><?= $model->getDeliveryPrice();?>  <?= Yii::t("OrderModule.order", "руб."); ?></small>
                            </strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4><?= Yii::t("OrderModule.order", "Всего"); ?></h4>
                    </td>
                    <td>
                        <p class="text-right lead">
                            <strong><?= $model->getTotalPriceWithDelivery(); ?></strong> <?= Yii::t("OrderModule.order", "руб."); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2">
                                        <?= Yii::t("OrderModule.order", "Детали заказа"); ?>
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
                                        <?= CHtml::encode($model->delivery->name); ?>
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
                                <tr>
                                    <td>
                                        <?= CHtml::activeLabel($model, 'address'); ?>
                                    </td>
                                    <td>
                                        <?= CHtml::encode($model->address); ?>
                                    </td>
                                </tr>
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
                <?php if (!$model->paid && $model->delivery->hasPaymentMethods()): ?>
                    <tr>
                        <td colspan="3">
                            <ul id="payment-methods">
                                <?php foreach ((array)$model->delivery->paymentMethods as $payment): ?>
                                    <li class="payment-method">
                                        <div class="checkbox">
                                            <input class="payment-method-radio" type="radio" name="payment_method_id" value="<?= $payment->id; ?>" checked="" id="payment-<?= $payment->id; ?>">
                                        </div>
                                        <h3>
                                            <label for="payment-<?= $payment->id; ?>"><?= CHtml::encode($payment->name); ?></label>
                                        </h3>

                                        <div class="description">
                                            <?= $payment->description; ?>
                                        </div>
                                        <div class="payment-form hidden">
                                            <?= $payment->getPaymentForm($model) ;?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <?php if($model->delivery->hasPaymentMethods()):?>
                    <tr>
                        <td colspan="3">
                            <p class="text-right">
                                <button type="submit" class="btn btn-success" id="start-payment">
                                    <?= Yii::t("OrderModule.order", "Оплатить"); ?>
                                    <span class="glyphicon glyphicon-play"></span>
                                </button>
                            </p>
                        </td>
                    </tr>
                    <?php endif;?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">
                            <p class="text-right">
                                <?= $model->getPaidStatus() . ' - ' . date('d.m.Y H:i', strtotime($model->payment_date)); ?>
                            </p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
