<?php $this->title = Yii::app()->getModule('yupe')->siteName; ?>

<div class="main__promo-slider grid">
    <div data-show='1' data-scroll='1' data-infinite='1' data-autoplay='5000' data-speed='1500' data-dots='1' class="promo-slider js-slick promo-slider js-slick promo-slider_main">
        <div class="promo-slider__slides js-slick__container">
            <img src="<?= $this->mainAssets ?>/images/content/slider/1.png">
            <img src="<?= $this->mainAssets ?>/images/content/slider/1.png">
            <img src="<?= $this->mainAssets ?>/images/content/slider/1.png">
            <img src="<?= $this->mainAssets ?>/images/content/slider/1.png">
        </div>
    </div>
</div>
<div class="main__hit-slider grid">
    <div class="hit-slider js-overlay-items">
        <div class="h2">Хиты</div>
        <?php $this->widget('application.modules.store.widgets.ProductsFromCategoryWidget', ['slug' => 'HITS']); ?>
    </div>
</div>
<div class="main__new-slider grid">
    <div class="new-slider js-overlay-items">
        <div class="h2">Новинки</div>
        <?php $this->widget('application.modules.store.widgets.ProductsFromCategoryWidget', ['slug' => 'chasy']); ?>
    </div>
</div>
<?php if(Yii::app()->hasModule('viewed')):?>
    <?php $this->widget('application.modules.viewed.widgets.ViewedWidget'); ?>
<?php endif ?>

<?php $this->widget('application.modules.store.widgets.ProducersWidget', ['limit' => 25]) ?>
