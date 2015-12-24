<?php
/**
 * @var array $brands
 * @var Producer $brand
 */
?>
<?php if ($brands): ?>
    <div class="main__best-brands grid">
        <div class="best-brands">
            <div class="best-brands__title">
                <div class="h3 h_upcase"><?= Yii::t('StoreModule.store', 'Producers list'); ?></div>
            </div>
            <div class="best-brands__body">
                <div class="grid">
                    <?php foreach ($brands as $brand): ?>
                        <div class="best-brands__item grid-module-2">
                            <a href="<?= Yii::app()->createUrl('/store/producer/view', ['slug' => $brand->slug]) ?>" title="<?= $brand->name ?>">
                                <img src="<?= $brand->getImageUrl(100, 100, false) ?>" class="best-brands__img" alt="<?= $brand->name ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
