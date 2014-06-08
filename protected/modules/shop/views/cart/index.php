<?php
/* @var $positions Product[] */

$this->pageTitle = Yii::t('ShopModule.catalog', 'Корзина');


$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/style.css');
//Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.simpleGal.js');
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/shop.js');

$this->breadcrumbs = array('Корзина');

?>
<div class="row-fluid">
    <div class="span12">
        <?php if (Yii::app()->shoppingCart->isEmpty()): ?>
            <h1>Корзина пуста</h1>
            В корзине нет товаров
        <?php else: ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Продукт</th>
                    <th>Количество</th>
                    <th class="text-center">Цена</th>
                    <th class="text-center">Сумма</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($positions as $position): ?>
                    <tr>
                        <td class="span5">
                            <?php $positionId = $position->getId(); ?>
                            <input type="hidden" class="position-id" value="<?php echo $positionId; ?>"/>

                            <div class="media">
                                <?php $productUrl = Yii::app()->createUrl('shop/catalog/show', array('name' => $position->alias)); ?>
                                <a class="thumbnail pull-left" href="<?php echo $productUrl; ?>">
                                    <img class="media-object" src="<?php echo $position->mainImage->getImageUrl(72, 72); ?>" style="width: 72px; height: 72px;">
                                </a>

                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="<?php echo $productUrl; ?>"><?php echo $position->name; ?></a>
                                    </h4>
                                    <?php foreach ($position->selectedVariants as $variant): ?>
                                        <h6><?php echo $variant->attribute->title; ?>: <?php echo $variant->getOptionValue(); ?></h6>
                                    <?php endforeach; ?>
                                    <span>Статус: </span><span class="text-<?php echo $position->in_stock ? "success" : "warning"; ?>"><strong><?php echo $position->in_stock ? "В наличии" : "Нет в наличии"; ?></strong></span>
                                </div>
                            </div>
                        </td>
                        <td class="span2">

                            <div class="input-prepend input-append">
                                <button class="btn btn-default cart-quantity-decrease" type="button" data-target="#cart_<?php echo $positionId; ?>">-</button>
                                <input type="text" class="span5 text-center position-count" value="<?php echo $position->getQuantity(); ?>" id="cart_<?php echo $positionId; ?>"/>
                                <button class="btn btn-default cart-quantity-increase" type="button" data-target="#cart_<?php echo $positionId; ?>">+</button>
                            </div>
                        </td>
                        <td class="span2 text-center"><strong><span class="position-price"><?php echo $position->getPrice(); ?></span> руб.</strong></td>
                        <td class="span2 text-center"><strong><span class="position-sum-price"><?php echo $position->getSumPrice(); ?></span> руб.</strong></td>
                        <td class="span1">
                            <button type="button" class="btn btn-danger cart-delete-product" data-position-id="<?php echo $positionId; ?>">
                                <span class="icon-remove"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td>  </td>
                    <td colspan="2"><h5>Промежуточный итог</h5></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-full-cost"><?php echo Yii::app()->shoppingCart->getCost(); ?></strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="radios"><b>Способ доставки</b></label>

                                <div class="controls">
                                    <?php $deliveryTypes = Delivery::model()->published()->findAll(); ?>
                                    <?php foreach ($deliveryTypes as $key => $delivery): ?>
                                        <label class="radio" for="delivery-<?php echo $delivery->id; ?>">
                                            <input type="radio" name="Order[delivery_id]" id="delivery-<?php echo $delivery->id; ?>"
                                                   value="<?php echo $delivery->id; ?>"
                                                   data-price="<?php echo $delivery->price; ?>"
                                                   data-free-from="<?php echo $delivery->free_from; ?>"
                                                   data-available-from="<?php echo $delivery->available_from; ?>"
                                                   data-separate-payment="<?php echo $delivery->separate_payment; ?>">
                                            <?php echo $delivery->name; ?> - <?php echo $delivery->price; ?> руб. (доступно от <?php echo $delivery->available_from; ?> руб.; бесплатно от <?php echo $delivery->free_from; ?> руб.; )
                                            <?php echo($delivery->separate_payment ? "Оплачивается отдельно" : ""); ?>
                                        </label>
                                        <div class="muted">
                                            <?php echo $delivery->description; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>  </td>
                    <td colspan="2"><h5>Стоимость доставки</h5></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-shipping-cost">0</strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td>  </td>
                    <td colspan="2"><h4>Всего</h4></td>
                    <td colspan="2" style="text-align: right;">
                        <h4><strong id="cart-full-cost-with-shipping">0</strong> руб.</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;">
                        <a href="<?php echo Yii::app()->createUrl('shop/catalog/index'); ?>" class="btn btn-default">
                            <span class="icon-shopping-cart"></span> Вернуться к каталогу
                        </a>
                        <button type="button" class="btn btn-success">
                            Создать заказ и перейти к оплате <span class="icon-play"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>