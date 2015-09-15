<!DOCTYPE html>
<html lang="<?= Yii::app()->language; ?>">

<head>
    <?php
    \yupe\components\TemplateEvent::fire(DefautThemeEvents::HEAD_START);

    Yii::app()->getController()->widget(
        'vendor.chemezov.yii-seo.widgets.SeoHead',
        [
            'httpEquivs' => [
                'Content-Type' => 'text/html; charset=utf-8',
                'X-UA-Compatible' => 'IE=edge,chrome=1',
                'Content-Language' => 'ru-RU',
                'viewport' => 'width=1200',
                'imagetoolbar' => 'no',
                'msthemecompatible' => 'no',
                'cleartype' => 'on',
                'HandheldFriendly' => 'True',
                'format-detection' => 'telephone=no',
                'format-detection' => 'address=no',
                'apple-mobile-web-app-capable' => 'yes',
                'apple-mobile-web-app-status-bar-style' => 'black-translucent',
            ],
            'defaultTitle' => $this->yupe->siteName,
            'defaultDescription' => $this->yupe->siteDescription,
            'defaultKeywords' => $this->yupe->siteKeyWords,
        ]
    );

    $mainAssets = Yii::app()->getTheme()->getAssetsUrl();

    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/scripts/libs/select2/select2.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/scripts/libs/slick/slick/slick.css');
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/styles/common.css');
    Yii::app()->getClientScript()->registerCssFile('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');

    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/scripts/common.min.js', CClientScript::POS_END);
    ?>
    <script type="text/javascript">
        var yupeTokenName = '<?= Yii::app()->getRequest()->csrfTokenName;?>';
        var yupeToken = '<?= Yii::app()->getRequest()->getCsrfToken();?>';
    </script>
    <?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::HEAD_END);?>
</head>

<body>
<?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::BODY_START);?>
<div class="main">
    <div class="main__navbar">
        <div class="navbar">
            <div class="navbar__wrapper grid">
                <div class="navbar__menu">
                    <?php if (Yii::app()->hasModule('menu')): ?>
                        <?php $this->widget('application.modules.menu.widgets.MenuWidget', ['name' => 'top-menu']); ?>
                    <?php endif; ?>
                </div>
                <div class="navbar__personal">
                    <div class="navbar__toolbar"><a href="javascript:void(0);" class="toolbar-button"><span class="toolbar-button__label"><i class="fa fa-heart-o fa-lg fa-fw"></i> Избранное</span><span class="badge badge_light-blue">33</span></a>
                        <a href="javascript:void(0);" class="toolbar-button"><span class="toolbar-button__label"><i class="fa fa-balance-scale fa-lg fa-fw"></i> Сравнение</span><span class="badge badge_light-blue">2</span>
                        </a>
                    </div>
                    <div class="navbar__user"><a href="javascript:void(0);" class="toolbar-button toolbar-button_dropdown"><span class="toolbar-button__label"><i class="fa fa-user fa-lg fa-fw"></i> Личный кабинет</span><span class="badge badge_light-blue"></span><div class="dropdown-menu"><div class="dropdown-menu__header">Иванов Василий</div><div class="dropdown-menu__item"><div class="dropdown-menu__link">Мои заказы</div></div><div class="dropdown-menu__item"><div class="dropdown-menu__link">Мои настройки</div></div><div class="dropdown-menu__item"><div class="dropdown-menu__link">Обратная связь</div></div><div class="dropdown-menu__separator"></div><div class="dropdown-menu__item"><div class="dropdown-menu__link dropdown-menu__link_exit">Выход</div></div></div></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main__header">
        <div class="header grid">
            <div class="header__item header-logo">
                <a href="javascript:void(0);" class="header__logo-link">
                    <img src="<?= $mainAssets ?>/images/logo.png" class="header-logo-image">
                </a>
            </div>
            <div class="header__item header-description">Магазин бытовой техники</div>
            <div class="header__item header-phone">
                <div class="header__phone">8 (456) 123-45-67</div><a href="javascript:void(0);" class="header-phone-callback">Заказать звонок</a>
            </div>
            <div class="header__item header-cart js-cart">
                <div class="header-cart__icon">
                    <div class="badge badge_light-blue">3</div>
                </div>
                <div class="header-cart__text-wrap">
                    <div class="header-cart__label">Моя корзина
                        <a href="javascript:void(0);" data-toggle="#cart-mini" class="header-cart__cart-toggle"></a>
                        <div class="cart-mini" id="cart-mini">
                            <div class="cart-mini__item js-cart__item">
                                <input type="hidden" value="5678" class="js-cart__item-price" />
                                <input type="hidden" value="1" class="js-cart__item-quantity" />
                                <div class="cart-mini__thumbnail">
                                    <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="cart-mini__img" />
                                </div>
                                <div class="cart-mini__info">
                                    <div class="cart-mini__title"><a href="javascript:void(0);" class="cart-mini__link">Samsung Galaxy Alpha SM-G850F 32Gb</a>
                                    </div>
                                    <div class="product-price">5678<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">7890<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                                <div class="cart-mini__delete-btn js-cart__delete"><i class="fa fa-trash-o"></i>
                                </div>
                            </div>
                            <div class="cart-mini__item js-cart__item">
                                <input type="hidden" value="5678" class="js-cart__item-price" />
                                <input type="hidden" value="1" class="js-cart__item-quantity" />
                                <div class="cart-mini__thumbnail">
                                    <img src="<?= $mainAssets ?>/images/content/product-small-2.jpg" class="cart-mini__img" />
                                </div>
                                <div class="cart-mini__info">
                                    <div class="cart-mini__title"><a href="javascript:void(0);" class="cart-mini__link">Samsung Galaxy Alpha SM-G850F 32Gb</a>
                                    </div>
                                    <div class="product-price">5678<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">7890<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                                <div class="cart-mini__delete-btn js-cart__delete"><i class="fa fa-trash-o"></i>
                                </div>
                            </div>
                            <div class="cart-mini__item js-cart__item">
                                <input type="hidden" value="5678" class="js-cart__item-price" />
                                <input type="hidden" value="1" class="js-cart__item-quantity" />
                                <div class="cart-mini__thumbnail">
                                    <img src="<?= $mainAssets ?>/images/content/product-small-3.jpg" class="cart-mini__img" />
                                </div>
                                <div class="cart-mini__info">
                                    <div class="cart-mini__title"><a href="javascript:void(0);" class="cart-mini__link">Samsung Galaxy Alpha SM-G850F 32Gb</a>
                                    </div>
                                    <div class="product-price">5678<span class="ruble"> руб.</span>
                                    </div>
                                    <div class="product-price product-price_old">7890<span class="ruble"> руб.</span>
                                    </div>
                                </div>
                                <div class="cart-mini__delete-btn js-cart__delete"><i class="fa fa-trash-o"></i>
                                </div>
                            </div>
                            <div class="cart-mini__bottom"><a href="javascript:void(0);" class="btn btn_success">Оформить</a>
                            </div>
                        </div>
                    </div>
                    <div class="header-cart__cost">
                        <div class="header-cart__cost-title">Сумма:</div>
                        <div class="header-cart__cost-price"><span class="js-cart__subtotal">1 345</span><span class="ruble"> руб.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main__search grid">
        <div class="search-bar">
            <div class="search-bar__wrapper"><a href="javascript:void(0);" data-toggle="#menu-catalog" class="search-bar__catalog-button">Каталог товаров</a>
                <input type="text" placeholder="Suns meet with definition at the greatly exaggerated center!" class="search-bar__input">
            </div>
            <div class="menu-catalog" id="menu-catalog">
                <ul>
                    <li class="has-submenu"><a href="javascript:void(0);">Мелкая техника для кухни</a>
                        <div class="menu-catalog-submenu">
                            <ul>
                                <li><a href="javascript:void(0);">Вытяжки</a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Встраиваемые</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Купольные</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0);">Встраиваемые духовые шкафы</a>
                                    <ul>
                                        <li><a href="javascript:void(0);">Aususs assimilant in hafnia!</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Heaven, uniqueness and a true afterworld.</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Hercle, demissio domesticus!.</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Ahoy, oh.</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Oh, urchin!</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Neutral kahlesses, to the universe.</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul>
                                <li><a href="javascript:void(0);">Never rob a bilge rat</a>
                                </li>
                                <li>
                                    <ul>
                                        <li><a href="javascript:void(0);">Ho-ho-ho!</a>
                                        </li>
                                        <li><a href="javascript:void(0);">Love me comrade, ye</a>
                                        </li>
                                        <li><a href="javascript:void(0);">How rainy. You hail</a>
                                        </li>
                                        <li><a href="javascript:void(0);">C'mon, never raid a</a>
                                        </li>
                                        <li><a href="javascript:void(0);">When the mast</a>
                                        </li>
                                        <li><a href="javascript:void(0);">The pirate commands</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="javascript:void(0);">Встраиваемая бытовая техника</a>
                    </li>
                    <li><a href="javascript:void(0);">Приготовление кофе</a>
                    </li>
                    <li><a href="javascript:void(0);">Аксессуары для бытовой техники</a>
                    </li>
                    <li><a href="javascript:void(0);">Кухонные принадлежности</a>
                    </li>
                    <li><a href="javascript:void(0);">Техника для дома</a>
                    </li>
                    <li><a href="javascript:void(0);">Климатическая техника</a>
                    </li>
                    <li class="has-submenu"><a href="javascript:void(0);">Кулеры, диспенсеры и фильтры для воды</a>
                        <div class="menu-catalog-submenu">The anchor sails with treasure, taste the pacific ocean before it falls.</div>
                    </li>
                    <li><a href="javascript:void(0);">Бытовая химия</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main__promo-slider grid">
        <div data-show='1' data-scroll='1' data-infinite='1' data-autoplay='5000' data-speed='1500' data-dots='1' class="promo-slider js-slick promo-slider js-slick promo-slider_main">
            <div class="promo-slider__slides js-slick__container">
                <img src="<?= $mainAssets ?>/images/content/slider/1.png">
                <img src="<?= $mainAssets ?>/images/content/slider/1.png">
                <img src="<?= $mainAssets ?>/images/content/slider/1.png">
                <img src="<?= $mainAssets ?>/images/content/slider/1.png">
            </div>
        </div>
    </div>
    <div class="main__hit-slider grid">
        <div class="hit-slider js-overlay-items">
            <div class="h2">Хиты</div>
            <div data-show='4' data-scroll='1' data-infinite="data-infinite" class="h-slider js-slick">
                <div class="h-slider__buttons h-slider__buttons_noclip">
                    <div class="btn h-slider__control h-slider__next js-slick__next"></div>
                    <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
                </div>
                <div class="h-slider__slides js-slick__container">
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_hit">
                                        <div class="product-label__text">Хит</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/1.png" class="product-vertical__img" />
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_hit">
                                        <div class="product-label__text">Хит</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/1.png" class="product-vertical__img" />
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_hit">
                                        <div class="product-label__text">Хит</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/1.png" class="product-vertical__img" />
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_hit">
                                        <div class="product-label__text">Хит</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/1.png" class="product-vertical__img" />
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_hit">
                                        <div class="product-label__text">Хит</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/1.png" class="product-vertical__img" />
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
                </div>
            </div>
        </div>
    </div>
    <div class="main__new-slider grid">
        <div class="new-slider js-overlay-items">
            <div class="h2">Новинки</div>
            <div data-show='4' data-scroll='1' data-infinite="data-infinite" class="h-slider js-slick">
                <div class="h-slider__buttons h-slider__buttons_noclip">
                    <div class="btn h-slider__control h-slider__next js-slick__next"></div>
                    <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
                </div>
                <div class="h-slider__slides js-slick__container">
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_new">
                                        <div class="product-label__text">New</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/2.png" class="product-vertical__img" />
                                    </div>
                                </a>
                                <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Samsung Galaxy Alpha SM-G850F</a>
                                    <div class="product-vertical__price">
                                        <div class="product-price">23 700<span class="ruble"> руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-vertical__extra">
                                    <div class="product-vertical-extra">
                                        <div class="product-vertical-extra__top">
                                            <div class="product-vertical-extra__rating">
                                                <div data-rate='2' class="rating">
                                                    <div class="rating__label">2.3</div>
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_new">
                                        <div class="product-label__text">New</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/2.png" class="product-vertical__img" />
                                    </div>
                                </a>
                                <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Samsung Galaxy Alpha SM-G850F</a>
                                    <div class="product-vertical__price">
                                        <div class="product-price">23 700<span class="ruble"> руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-vertical__extra">
                                    <div class="product-vertical-extra">
                                        <div class="product-vertical-extra__top">
                                            <div class="product-vertical-extra__rating">
                                                <div data-rate='2' class="rating">
                                                    <div class="rating__label">2.3</div>
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_new">
                                        <div class="product-label__text">New</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/2.png" class="product-vertical__img" />
                                    </div>
                                </a>
                                <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Samsung Galaxy Alpha SM-G850F</a>
                                    <div class="product-vertical__price">
                                        <div class="product-price">23 700<span class="ruble"> руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-vertical__extra">
                                    <div class="product-vertical-extra">
                                        <div class="product-vertical-extra__top">
                                            <div class="product-vertical-extra__rating">
                                                <div data-rate='2' class="rating">
                                                    <div class="rating__label">2.3</div>
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_new">
                                        <div class="product-label__text">New</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/2.png" class="product-vertical__img" />
                                    </div>
                                </a>
                                <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Samsung Galaxy Alpha SM-G850F</a>
                                    <div class="product-vertical__price">
                                        <div class="product-price">23 700<span class="ruble"> руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-vertical__extra">
                                    <div class="product-vertical-extra">
                                        <div class="product-vertical-extra__top">
                                            <div class="product-vertical-extra__rating">
                                                <div data-rate='2' class="rating">
                                                    <div class="rating__label">2.3</div>
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
                    <div class="h-slider__slide js-overlay-item">
                        <div class="grid-module-3">
                            <article class="product-vertical">
                                <div class="product-vertical__label">
                                    <div class="product-label product-label_new">
                                        <div class="product-label__text">New</div>
                                    </div>
                                </div>
                                <a href="javascript:void(0);">
                                    <div class="product-vertical__thumbnail">
                                        <img src="<?= $mainAssets ?>/images/content/product-vertical/2.png" class="product-vertical__img" />
                                    </div>
                                </a>
                                <div class="product-vertical__content"><a href="javascript:void(0);" class="product-vertical__title">Samsung Galaxy Alpha SM-G850F</a>
                                    <div class="product-vertical__price">
                                        <div class="product-price">23 700<span class="ruble"> руб.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-vertical__extra">
                                    <div class="product-vertical-extra">
                                        <div class="product-vertical-extra__top">
                                            <div class="product-vertical-extra__rating">
                                                <div data-rate='2' class="rating">
                                                    <div class="rating__label">2.3</div>
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
                </div>
            </div>
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
                                        <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
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
                                        <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
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
                                        <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
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
                                        <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
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
                                        <img src="<?= $mainAssets ?>/images/content/product-small-1.jpg" class="product-mini__img">
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
    <div class="main__best-brands grid">
        <div class="best-brands">
            <div class="best-brands__title">
                <div class="h3 h_upcase">Бренды</div>
            </div>
            <div class="best-brands__body">
                <div class="grid">
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/apple.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/braun.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/lg.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/panasonic.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/philips.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/samsung.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/sharp.png" class="best-brands__img">
                    </div>
                    <div class="best-brands__item grid-module-2">
                        <img src="<?= $mainAssets ?>/images/content/brands/toshiba.png" class="best-brands__img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main__footer">
        <div class="footer">
            <div class="grid">
                <div class="footer__wrap">
                    <div class="footer__group">
                        <div class="footer__item">&copy; Yupe! <?= date('Y') ?></div>
                        <div class="footer__item footer__item_mute">Все права защищены.</div>
                    </div>
                    <div class="footer__group">
                        <?php if (Yii::app()->hasModule('menu')): ?>
                            <?php $this->widget('application.modules.menu.widgets.MenuWidget', [
                                'name' => 'top-menu',
                                'layout' => 'footer'
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="footer__group">
                        <div class="footer__item"><a href="javascript:void(0);" class="footer__link">Телефония, МР3-плееры, GPS</a>
                        </div>
                        <div class="footer__item"><a href="javascript:void(0);" class="footer__link">Домашнее видео</a>
                        </div>
                        <div class="footer__item"><a href="javascript:void(0);" class="footer__link">Детские товары</a>
                        </div>
                        <div class="footer__item"><a href="javascript:void(0);" class="footer__link">Активный отдых и туризм</a>
                        </div>
                        <div class="footer__item"><a href="javascript:void(0);" class="footer__link">Музыкальные инструменты</a>
                        </div>
                    </div>
                    <div class="footer__group">
                        <div class="footer__item footer__item_header">Контакты</div>
                        <div class="footer__item"><i class="fa fa-phone fa-fw"></i> (123) 456-78-90, 0 (123) 456-78-90</div>
                        <div class="footer__item"><i class="fa fa-envelope fa-fw"></i> E-mail: partner@YupeStore.net</div>
                        <div class="footer__item"><i class="fa fa-skype fa-fw"></i> Skype: YupeStore</div>
                    </div>
                    <div class="footer__group">
                        <div class="footer__item footer__item_header">Работаем</div>
                        <div class="footer__item">Пн–Пт 09:00–20:00</div>
                        <div class="footer__item">Сб 09:00–17:00</div>
                        <div class="footer__item">Вс выходной</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \yupe\components\TemplateEvent::fire(DefautThemeEvents::BODY_END);?>
</body>
</html>