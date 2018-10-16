<?php
/**
 * @var StoreCategory $category
 * @var array $products Product objects array
 * @var Product $product
 */
?>

<div data-show='4' data-scroll='1' data-infinite="data-infinite" class="h-slider js-slick">
    <div class="h-slider__buttons h-slider__buttons_noclip">
        <div class="btn h-slider__control h-slider__next js-slick__next"></div>
        <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
    </div>
    <div class="h-slider__slides js-slick__container">
        <?php foreach ($products->getData() as $product): ?>
            <?php $this->render('_item', ['product' => $product]) ?>
        <?php endforeach; ?>
    </div>
</div>
