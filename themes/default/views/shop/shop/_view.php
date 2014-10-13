<?php
/**
 * @var $this ShopController
 * @var $assets string
 * @var $data Good
 */
?>
<div class="post span3">
    <a class="thumb" href="<?=$this->createUrl('/shop/shop/show', array('name' => $data->alias)); ?>"><?php
        echo CHtml::image(
            !$data->isNewRecord && $data->image
                ? $data->getImageUrl(270, 270)
                : $assets . '/images/no-shop-photo.jpg',
            $data->name, array(
                'class' => 'preview-image img-polaroid',
            )
        ); ?></a>
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->name), array('/catalog/catalog/show', 'name' => $data->alias)); ?>
    </div>

    <div class="content">
        <p><?php echo $data->short_description; ?></p>
    </div>
    <div class="nav">
        <span class="price"><?php echo Yii::app()->numberFormatter->formatCurrency( $data->price, 'RUR'); ?></span>
        <br/>
        <?php echo CHtml::link(Yii::t('ShopModule.shop', 'Add to basket'), array('/shop/cart/add', 'id' => $data->id), array( 'class' => 'btn')); ?>
    </div>
</div>