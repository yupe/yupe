<?php $this->pageTitle = Yii::app()->getModule('yupe')->siteName; ?>

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
<div class="main__recently-viewed-slider">
    <div class="grid">
        <div class="h3">Вы недавно смотрели</div>
        <div data-show='3' data-scroll='3' data-infinite="data-infinite" class="h-slider js-slick">
            <div class="h-slider__buttons h-slider__buttons_noclip">
                <div class="btn h-slider__control h-slider__next js-slick__next"></div>
                <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
            </div>
            <div class="h-slider__slides js-slick__container">
                <div class="h-slider__slide">
                    <div class="grid-module-4">
                        <div class="product-mini">
                            <div class="product-mini__thumbnail">
                                <a href="javascript:void(0);">
                                    <img src="<?= $this->mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
                                </a>
                            </div>
                            <div class="product-mini__info">
                                <div class="product-mini__title"><a href="javascript:void(0);" class="product-mini__link">Humani generis de regius</a>
                                </div>
                                <div class="product-mini__price">
                                    <div class="product-price">12304<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-slider__slide">
                    <div class="grid-module-4">
                        <div class="product-mini">
                            <div class="product-mini__thumbnail">
                                <a href="javascript:void(0);">
                                    <img src="<?= $this->mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
                                </a>
                            </div>
                            <div class="product-mini__info">
                                <div class="product-mini__title"><a href="javascript:void(0);" class="product-mini__link">Humani generis de regius</a>
                                </div>
                                <div class="product-mini__price">
                                    <div class="product-price">12304<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-slider__slide">
                    <div class="grid-module-4">
                        <div class="product-mini">
                            <div class="product-mini__thumbnail">
                                <a href="javascript:void(0);">
                                    <img src="<?= $this->mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
                                </a>
                            </div>
                            <div class="product-mini__info">
                                <div class="product-mini__title"><a href="javascript:void(0);" class="product-mini__link">Humani generis de regius</a>
                                </div>
                                <div class="product-mini__price">
                                    <div class="product-price">12304<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-slider__slide">
                    <div class="grid-module-4">
                        <div class="product-mini">
                            <div class="product-mini__thumbnail">
                                <a href="javascript:void(0);">
                                    <img src="<?= $this->mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
                                </a>
                            </div>
                            <div class="product-mini__info">
                                <div class="product-mini__title"><a href="javascript:void(0);" class="product-mini__link">Humani generis de regius</a>
                                </div>
                                <div class="product-mini__price">
                                    <div class="product-price">12304<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-slider__slide">
                    <div class="grid-module-4">
                        <div class="product-mini">
                            <div class="product-mini__thumbnail">
                                <a href="javascript:void(0);">
                                    <img src="<?= $this->mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
                                </a>
                            </div>
                            <div class="product-mini__info">
                                <div class="product-mini__title"><a href="javascript:void(0);" class="product-mini__link">Humani generis de regius</a>
                                </div>
                                <div class="product-mini__price">
                                    <div class="product-price">12304<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->widget('application.modules.store.widgets.ProducersWidget', ['limit' => 25]) ?>
