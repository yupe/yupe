<?php
/**
 * @var array $brands
 * @var Producer $brand
 * @var $title string
 */
?>
<?php if ($brands): ?>
    <div class="main__best-brands grid">
        <div class="best-brands">
            <div class="best-brands__title">
                <div class="h3 h_upcase"><?= $title ?></div>
            </div>
            <div class="best-brands__body">
                <div class="grid">
                    <?php foreach ($brands as $brand): ?>
                        <div class="best-brands__item grid-module-2">
                            <a href="<?= Yii::app()->createUrl('/store/producer/view', ['slug' => $brand->slug]) ?>" title="<?= $brand->name ?>">
                                <img src="<?= StoreImage::producer($brand, 100, 100) ?>" class="best-brands__img" alt="<?= $brand->name ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
