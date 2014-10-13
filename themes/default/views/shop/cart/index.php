<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 31.05.14
 * Time: 14:34
 */

/**
 * @var $dataProvider CActiveDataProvider
 * @var $cart ShopCart
 * @var $this CartController
 */
$this->pageTitle = Yii::t('ShopModule.shop', 'Cart');
$this->breadcrumbs = array(Yii::t('CatalogModule.catalog', 'Products') => array('/shop/shop/index'),Yii::t('ShopModule.shop', 'Cart'));
$assets = Yii::app()->assetManager->getPublishedUrl(
    Yii::app()->theme->basePath . "/web/"
);
?>

<h1><?=Yii::t('ShopModule.shop', 'Cart'); ?></h1>

<div class="row">
    <div class="alert alert-info span5">
        В вашей корзине <?=count($cart->shopCartGoods)?> ед. товаров на общую сумму Общая стоимость товаров <?=Yii::app()->numberFormatter->formatCurrency( $cart->sum, 'RUR')?>
    </div>
    <div class="span3"><a href="<?=$this->createUrl('order/create', array('id' => $cart->id ))?>" class="btn btn-primary pull-right btn-block btn-large">Оформить заказ</a></div>
</div>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'shop-cart-good-grid',
    'dataProvider' => $dataProvider,
    'columns'      => array(
        // image
        array(
            //'htmlOptions' => array('style' => 'width:20px'),
            'type' => 'raw',
            'value' => function($data) use ($assets) {
                    /**
                     * @var ShopCartGood $data
                     */
                    return CHtml::image(
                        !empty($data->catalogGood->image)
                            ? $data->catalogGood->getImageUrl(70, 70)
                            :  $assets . '/images/no-shop-photo-thumb.jpg',
                        $data->catalogGood->name, array(
                            'class' => 'preview-image img-polaroid',
                        )
                    );
                }
        ),
        // name
        array(
            'name'  => 'catalogGood.name',
            'header' => 'Товар'
        ),
        // price
        array(
            'header' => 'Цена',
            'value' => 'Yii::app()->numberFormatter->formatCurrency( $data->catalogGood->price, "RUR" );'
        ),
    ),
)); ?>

<div class="row">
    <div class="alert alert-info span5">
        В вашей корзине <?=count($cart->shopCartGoods)?> ед. товаров на общую сумму Общая стоимость товаров <?=Yii::app()->numberFormatter->formatCurrency( $cart->sum, 'RUR')?>
    </div>
    <div class="span3"><a href="<?=$this->createUrl('order/create', array('id' => $cart->id ))?>" class="btn btn-primary pull-right btn-block btn-large">Оформить заказ</a></div>
</div>


