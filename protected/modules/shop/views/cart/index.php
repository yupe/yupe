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
        <table class="table table-hover">
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
            <?php foreach($positions as $position):?>
            <tr>
                <td class="span5">
                    <?php $positionId = $position->getId();?>
                    <input type="hidden" class="position-id" value="<?php echo $positionId;?>"/>
                    <div class="media">
                        <?php $productUrl = Yii::app()->createUrl('shop/catalog/show', array('name' => $position->alias));?>
                        <a class="thumbnail pull-left" href="<?php echo $productUrl;?>">
                            <img class="media-object" src="<?php echo $position->mainImage->getImageUrl(72,72);?>" style="width: 72px; height: 72px;">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="<?php echo $productUrl;?>"><?php echo $position->name;?></a>
                            </h4>
                            <?php foreach($position->selectedVariants as $variant):?>
                                <h6><?php echo $variant->attribute->title;?>: <?php echo $variant->getOptionValue();?></h6>
                            <?php endforeach;?>
                            <span>Статус: </span><span class="text-<?php echo $position->in_stock ? "success" : "warning"; ?>"><strong><?php echo $position->in_stock ? "В наличии" : "Нет в наличии"; ?></strong></span>
                        </div>
                    </div>
                </td>
                <td class="span2">

                    <div class="input-prepend input-append">
                        <button class="btn btn-default cart-quantity-decrease" type="button" data-target="#cart_<?php echo $positionId;?>">-</button>
                        <input type="text" class="span5 text-center position-count" value="<?php echo $position->getQuantity();?>" id="cart_<?php echo $positionId;?>"/>
                        <button class="btn btn-default cart-quantity-increase" type="button"  data-target="#cart_<?php echo $positionId;?>">+</button>
                    </div>
                </td>
                <td class="span2 text-center"><strong><span class="position-price"><?php echo $position->getPrice();?></span> руб.</strong></td>
                <td class="span2 text-center"><strong><span class="position-sum-price"><?php echo $position->getSumPrice();?></span> руб.</strong></td>
                <td class="span1">
                    <button type="button" class="btn btn-danger cart-delete-product" data-position-id="<?php echo $positionId;?>">
                        <span class="icon-remove"></span>
                    </button>
                </td>
            </tr>
            <?php endforeach;?>
            <tr>
                <td>  </td>
                <td>  </td>
                <td><h4>Всего</h4></td>
                <td colspan="2"  style="text-align: right;">
                    <h4><strong id="cart-full-cost"><?php echo Yii::app()->shoppingCart->getCost();?></strong> руб.</h4>
                </td>
            </tr>
            <tr>
                <td>  </td>

                <td colspan="2" style="text-align: right;">
                    <button type="button" class="btn btn-default">
                        <span class="icon-shopping-cart"></span> Вернуться
                    </button>
                </td>
                <td colspan="2">
                    <button type="button" class="btn btn-success">
                        Оплатить <span class="icon-play"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>