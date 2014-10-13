
<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 31.05.14
 * Time: 12:48
 */
/**
 * @var $cart ShopCart
 * @var $this CartWidget
 */
?>
<a class="btn btn-block btn-large" href="<?=$this->controller->createUrl('cart/index'); ?>"><i class="icon-shopping-cart"></i> Корзина: <?=count($cart->shopCartGoods)?> ед., <?=Yii::app()->numberFormatter->formatCurrency($cart->sum, 'RUR')?></a>