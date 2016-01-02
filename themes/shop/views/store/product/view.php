<?php

/* @var $product Product */

$this->pageTitle = $product->getMetaTitle();
$this->description = $product->getMetaDescription();
$this->keywords = $product->getMetaKeywords();

Yii::app()->getClientScript()->registerScriptFile($this->mainAssets . '/js/store.js', CClientScript::POS_END);

$this->breadcrumbs = array_merge(
    [Yii::t("StoreModule.store", 'Catalog') => ['/store/product/index']],
    $product->category ? $product->category->getBreadcrumbs(true) : [],
    [CHtml::encode($product->name)]
);
?>
<div class="main__product-description grid">
    <div class="product-description">
        <div class="product-description__img-block grid-module-6">
            <div class="product-gallery js-product-gallery">
                <div class="product-gallery__body">
                    <div data-product-image class="product-gallery__img-wrap">
                        <img src="<?= StoreImage::product($product); ?>" class="product-gallery__main-img">
                    </div>
                    <?php if ($product->isSpecial()): ?>
                        <div class="product-gallery__label">
                            <div class="product-label product-label_hit">
                                <div class="product-label__text">Хит</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="product-gallery__nav">
                    <a href="<?= StoreImage::product($product); ?>" rel="group" data-product-thumbnail
                       class="product-gallery__nav-item">
                        <img src="<?= $product->getImageUrl(60, 60, false); ?>" alt=""
                             class="product-gallery__nav-img">
                    </a>
                    <?php foreach ($product->getImages() as $key => $image): ?>
                        <a href="<?= $image->getImageUrl(); ?>" rel="group" data-product-thumbnail
                           class="product-gallery__nav-item">
                            <img src="<?= $image->getImageUrl(60, 60, false); ?>" alt=""
                                 class="product-gallery__nav-img">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="product-description__entry grid-module-6">
            <div class="entry">
                <div class="entry__toolbar">
                    <div class="entry__toolbar-right">
                        <?php if(Yii::app()->hasModule('favorite')):?>
                            <?php $this->widget('application.modules.favorite.widgets.FavoriteControl', ['product' => $product, 'view' => '_in-product']);?>
                        <?php endif;?>
                        <?php if(Yii::app()->hasModule('compare')):?>
                            <a href="javascript:void(0);" class="entry__toolbar-button"><i class="fa fa-balance-scale"></i></a>
                        <?php endif;?>
                    </div>
                </div>
                <div class="entry__title">
                    <h1 class="h1"><?= CHtml::encode($product->name); ?></h1>
                </div>
                <div class="entry__wysiwyg">
                    <div class="wysiwyg">
                        <?= $product->short_description; ?>
                    </div>
                </div>
                <form action="<?= Yii::app()->createUrl('cart/cart/add'); ?>" method="post">
                    <input type="hidden" name="Product[id]" value="<?= $product->id; ?>"/>
                    <?= CHtml::hiddenField(
                        Yii::app()->getRequest()->csrfTokenName,
                        Yii::app()->getRequest()->csrfToken
                    ); ?>

                    <?php if ($product->getVariantsGroup()): ?>

                        <div class="entry__title">
                            <h2 class="h3 h_upcase"><?= Yii::t("StoreModule.store", "Variants"); ?></h2>
                        </div>

                        <div class="entry__variants">
                            <?php foreach ($product->getVariantsGroup() as $title => $variantsGroup): ?>
                                <div class="entry__variant">
                                    <div class="entry__variant-title"><?= CHtml::encode($title); ?></div>
                                    <div class="entry__variant-value">
                                        <?=
                                        CHtml::dropDownList('ProductVariant[]', null, CHtml::listData($variantsGroup, 'id', 'optionValue'), [
                                            'empty' => '--выберите--',
                                            'class' => 'js-select2 entry__variant-value-select noborder',
                                            'options' => $product->getVariantsOptions()
                                        ]); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="entry__price"><?= Yii::t("StoreModule.store", "Price"); ?>:
                        <div class="product-price">
                            <input type="hidden" id="base-price"
                                   value="<?= round($product->getResultPrice(), 2); ?>"/>
                            <span id="result-price"><?= round($product->getResultPrice(), 2); ?></span>
                            <span class="ruble"> <?= Yii::t("StoreModule.store", Yii::app()->getModule('store')->currency); ?></span>
                            <?php if ($product->hasDiscount()): ?>
                                <div class="product-price product-price_old"><?= round($product->getBasePrice(), 2) ?><span class="ruble"> <?= Yii::t("StoreModule.store", Yii::app()->getModule('store')->currency); ?></span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (Yii::app()->hasModule('order')): ?>
                        <div class="entry__count">
                            <div class="entry__count-label">Кол-во:</div>
                            <div class="entry__count-input">
                                <span data-min-value='1' data-max-value='99' class="spinput js-spinput">
                                    <span class="spinput__minus js-spinput__minus product-quantity-decrease"></span>
                                    <input name="Product[quantity]" value="1" class="spinput__value" id="product-quantity-input"/>
                                    <span class="spinput__plus js-spinput__plus product-quantity-increase"></span>
                                </span>
                            </div>
                            <div class="entry__cart-button">
                                <button class="btn btn_cart" id="add-product-to-cart"
                                        data-loading-text="<?= Yii::t("StoreModule.store", "Adding"); ?>">В корзину
                                </button>
                            </div>
                        </div>
                        <div class="entry__subtotal">
                            <span id="product-result-price"><?= round($product->getResultPrice(), 2); ?></span> x
                            <span id="product-quantity">1</span> =
                            <span id="product-total-price"><?= round($product->getResultPrice(), 2); ?></span>
                            <span class="ruble"> <?= Yii::t("StoreModule.store", Yii::app()->getModule('store')->currency); ?></span></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <div class="product-features">
        <div class="product-features__block product-features__block_delivery">
            <div class="product-features__header">Доставка</div>
            <div class="product-features__item">Почта России</div>
            <div class="product-features__item">Курьер</div>
            <div class="product-features__item">Самовывоз</div>
        </div>
        <div class="product-features__block product-features__block_payment">
            <div class="product-features__header">Оплата</div>
            <div class="product-features__item">Наличные</div>
            <div class="product-features__item">Online</div>
            <div class="product-features__item">Сбербанк</div>
        </div>
        <div class="product-features__block product-features__block_warranty">
            <div class="product-features__header">Гарантии</div>
            <div class="product-features__item">Возврат</div>
            <div class="product-features__item">Обмен</div>
        </div>
    </div>
</div>

<div class="main__product-tabs grid">
    <div class="tabs tabs_classic tabs_gray js-tabs">
        <ul data-nav="data-nav" class="tabs__list">
            <li class="tabs__item"><a href="#spec"
                                      class="tabs__link"><?= Yii::t("StoreModule.store", "Characteristics"); ?></a>
            </li>
            <li class="tabs__item"><a href="#description"
                                      class="tabs__link"><?= Yii::t("StoreModule.store", "Description"); ?></a>
            </li>
            <li class="tabs__item"><a href="#reviews"
                                      class="tabs__link"><?= Yii::t("StoreModule.store", "Comments"); ?></a>
            </li>
        </ul>
        <div class="tabs__bodies js-tabs-bodies">
            <div id="spec" class="tabs__body js-tab">
                <div class="product-spec">
                    <div class="product-spec__body">
                        <?php if ($product->producer_id): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "Producer"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= CHtml::encode($product->getProducerName()); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php if ($product->sku): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "SKU"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= CHtml::encode($product->sku); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php if ($product->length): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "Length"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= round($product->length, 2); ?> <?= Yii::t("StoreModule.store", "m"); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php if ($product->width): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "Width"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= round($product->width, 2); ?> <?= Yii::t("StoreModule.store", "m"); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php if ($product->height): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "Height"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= round($product->height, 2); ?> <?= Yii::t("StoreModule.store", "m"); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php if ($product->weight): ?>
                            <dl class="product-spec-item">
                                <dt class="product-spec-item__name">
                                    <span class="product-spec-item__name-inner">
                                        <?= Yii::t("StoreModule.store", "Weight"); ?>
                                    </span>
                                </dt>
                                <dd class="product-spec-item__value">
                                    <span class="product-spec-item__value-inner">
                                        <?= round($product->weight, 2); ?> <?= Yii::t("StoreModule.store", "m"); ?>
                                    </span>
                                </dd>
                            </dl>
                        <?php endif; ?>

                        <?php foreach ($product->getAttributeGroups() as $groupName => $items): ?>
                            <h2 class="h3 product-spec__header"><?= CHtml::encode($groupName); ?></h2>
                            <?php foreach ($items as $attribute): ?>
                                <dl class="product-spec-item">
                                    <dt class="product-spec-item__name">
                                        <span class="product-spec-item__name-inner">
                                            <?= CHtml::encode($attribute->title); ?>
                                        </span>
                                    </dt>
                                    <dd class="product-spec-item__value">
                                        <span class="product-spec-item__value-inner">
                                            <?= AttributeRender::renderValue($attribute, $product->attribute($attribute)); ?>
                                        </span>
                                    </dd>
                                </dl>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div id="description" class="tabs__body js-tab">
                <div class="wysiwyg">
                    <?= $product->description ?>
                </div>
            </div>
            <div id="reviews" class="tabs__body js-tab">
                <div class="product-reviews">
                    <?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
                        'redirectTo' => $product->getUrl(),
                        'model' => $product,
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->widget('application.modules.store.widgets.LinkedProductsWidget', ['product' => $product, 'code' => null,]); ?>

