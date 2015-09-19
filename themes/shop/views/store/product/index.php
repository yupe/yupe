<?php

$mainAssets = Yii::app()->getTheme()->getAssetsUrl();
//Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/store.js');

/* @var $category StoreCategory */

$this->breadcrumbs = [Yii::t("StoreModule.store", "Catalog")];

?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t("StoreModule.store", "Product catalog"); ?></h1>
</div>

<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-3">
            <div class="catalog-filter">
                <form id="store-filter" name="store-filter" method="get">
                    <?php $this->widget('application.modules.store.widgets.filters.PriceFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.CategoryFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.ProducerFilterWidget'); ?>
                    <?php $this->widget('application.modules.store.widgets.filters.FilterBlockWidget', ['attributes' => '*']); ?>
                </form>
            </div>
        </div>
        <div class="col grid-module-9">
            <div class="catalog-controls">
                <div class="catalog-controls__col">
                    <div class="sorter">
                        <div class="sorter__description">Сортировать:</div><a href="javascript:void(0);" class="asc">по популярности</a><a href="javascript:void(0);" class="desc">по цене</a><a href="javascript:void(0);">по названию</a>
                    </div>
                </div>
                <div class="catalog-controls__col catalog-controls__col_right">
                    <div class="view-switch">
                        <div class="view-switch__caption"></div>
                        <div class="view-switch__toggle">
                            <div class="switch">
                                <div class="switch__item">
                                    <div class="switch-item">
                                        <input type="radio" id="view-switch-list" name="view-switch" value="list" class="switch-item__input">
                                        <label for="view-switch-list" class="switch-item__label"><i class="fa fa-th-list fa-fw"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="switch__item">
                                    <div class="switch-item">
                                        <input type="radio" id="view-switch-grid" name="view-switch" value="grid" checked class="switch-item__input">
                                        <label for="view-switch-grid" class="switch-item__label"><i class="fa fa-th fa-fw"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="catalog">
                <div class="catalog__items">
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="catalog__item">
                        <article class="product-vertical">
                            <div class="product-vertical__label">
                                <div class="product-label product-label_hit">
                                    <div class="product-label__text">Хит</div>
                                </div>
                            </div>
                            <a href="javascript:void(0);">
                                <div class="product-vertical__thumbnail">
                                    <img src="assets/images/content/product-vertical/1.png" class="product-vertical__img" />
                                </div>
                            </a>
                            <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Смартфон Sony Xperia V (LT25i Black)</a>
                                <div class="product-vertical__price">
                                    <div class="product-price">12 990<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">15 990<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-vertical__extra">
                                <div class="product-vertical-extra">
                                    <div class="product-vertical-extra__top">
                                        <div class="product-vertical-extra__rating">
                                            <div data-rate='5' class="rating">
                                                <div class="rating__label">4.5</div>
                                                <div class="rating__corner">
                                                    <div class="rating__triangle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-vertical-extra__reviews"><a href="javascript:void(0);" class="reviews-link">6 отзывов</a>
                                        </div>
                                        <div class="product-vertical-extra__stock">
                                            <div class="in-stock">В наличии</div>
                                        </div>
                                    </div>
                                    <div class="product-vertical-extra__toolbar">
                                        <div class="product-vertical-extra__button"><i class="fa fa-heart-o"></i>
                                        </div>
                                        <div class="product-vertical-extra__button"><i class="fa fa-balance-scale"></i>
                                        </div>
                                        <div class="product-vertical-extra__cart"><a href="javascript:void(0);" class="btn btn_cart">В корзину</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="catalog__pagination">
                    <ul class="pagination">
                        <li class="prev disabled"><a href="javascript:void(0);"><i class="fa fa-long-arrow-left"></i></a>
                        </li>
                        <li class="active"><a href="javascript:void(0);">1</a>
                        </li>
                        <li><a href="javascript:void(0);">2</a>
                        </li>
                        <li><a href="javascript:void(0);">3</a>
                        </li>
                        <li><a href="javascript:void(0);">4</a>
                        </li>
                        <li class="next"><a href="javascript:void(0);"><i class="fa fa-long-arrow-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
