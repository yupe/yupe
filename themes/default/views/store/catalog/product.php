<?php

/* @var $product Product */

$this->pageTitle = $product->getMetaTitle();
$this->description = $product->getMetaDescription();
$this->keywords = $product->getMetaKeywords();

$mainAssets = Yii::app()->getModule('store')->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/jquery.simpleGal.js');

Yii::app()->getClientScript()->registerCssFile(Yii::app()->getTheme()->getAssetsUrl() . '/css/store-frontend.css');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getTheme()->getAssetsUrl() . '/js/store.js');

$this->breadcrumbs = array_merge(
    [Yii::t("StoreModule.catalog", 'Каталог') => ['/store/catalog/index']],
    $product->mainCategory ? $product->mainCategory->getBreadcrumbs(true) : [],
    [CHtml::encode($product->name)]
);
?>
<div class="row">
<div class="col-sm-12">
<div class="row">
    <div class="col-sm-12">
        <span class="title"><?= CHtml::encode($product->name); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 product-feature">
        <div class="row">
            <div class="col-sm-4">
                <div class="thumbnails">
                    <div class="image-preview">
                        <img src="<?= $product->getImageUrl(); ?>" alt="" class="" id="main-image">
                    </div>
                    <a href="<?= $product->getImageUrl(); ?>">
                        <img src="<?= $product->getImageUrl(50, 50); ?>"/>
                    </a>
                    <?php foreach ($product->getImages() as $key => $image): { ?>
                        <a href="<?= $image->getImageUrl(); ?>">
                            <img src="<?= $image->getImageUrl(50, 50); ?>"/>
                        </a>
                    <?php } endforeach; ?>
                </div>
            </div>
            <div class="col-sm-8">
                <?= $product->isInStock() ? Yii::t("StoreModule.catalog", "В наличии") : Yii::t(
                    "StoreModule.catalog",
                    "Нет в наличии"
                ); ?>
                <br/>
                <?= $product->quantity; ?> <?= Yii::t("StoreModule.catalog", "в наличии"); ?>
                <br/>
                <br/>

                <div class="properties">
                    <?php foreach ($product->getAttributeGroups() as $groupName => $items): { ?>
                        <div class="propertyGroup">
                            <h4>
                                <span><?= CHtml::encode($groupName); ?></span>
                            </h4>
                            <table>
                                <tbody>
                                <?php foreach ($items as $attribute): { ?>
                                    <tr>
                                        <td class="key">
                                            <span><?= CHtml::encode($attribute->title); ?></span>
                                        </td>
                                        <td class="value">
                                            <?= $attribute->renderValue($product->attr($attribute->name)); ?>
                                        </td>
                                    </tr>
                                <?php } endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } endforeach; ?>
                </div>
                <br/>
                <h4><?= Yii::t("StoreModule.catalog", "Описание"); ?></h4>
                <?= $product->short_description; ?>
                <hr>
                <h4><?= Yii::t("StoreModule.catalog", "Варианты"); ?></h4>

                <form action="<?= Yii::app()->createUrl('cart/cart/add'); ?>" method="post">
                    <input type="hidden" name="Product[id]" value="<?= $product->id; ?>"/>
                    <?= CHtml::hiddenField(
                        Yii::app()->getRequest()->csrfTokenName,
                        Yii::app()->getRequest()->csrfToken
                    ); ?>
                    <table class="table table-condensed">
                        <?php foreach ($product->getVariantsGroup() as $title => $variantsGroup): { ?>
                            <tr>
                                <td style="padding: 0;">
                                    <?= CHtml::encode($title); ?>
                                </td>
                                <td>
                                    <?=
                                    CHtml::dropDownList(
                                        'ProductVariant[]',
                                        null,
                                        CHtml::listData($variantsGroup, 'id', 'optionValue'),
                                        array('empty' => '', 'class' => 'form-control')
                                    ); ?>
                                </td>
                            </tr>
                        <?php } endforeach; ?>
                    </table>
                    <div>
                        <input type="hidden" id="base-price" value="<?= round($product->getResultPrice(), 2); ?>"/>

                        <p>
                            <?= Yii::t("StoreModule.catalog", "Цена"); ?>
                            : <?= round($product->getBasePrice(), 2); ?> <?= Yii::t("StoreModule.catalog", "руб."); ?>
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.catalog", "Фиксированная цена со скидкой"); ?>
                            : <?= round($product->getDiscountPrice(), 2); ?>
                            <?= Yii::t("StoreModule.catalog", "руб."); ?>
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.catalog", "Скидка"); ?>: <?= round($product->discount); ?>%
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.catalog", "Итоговая цена"); ?>: <span
                                id="result-price"><?= round($product->getResultPrice(), 2); ?></span>
                            <?= Yii::t("StoreModule.catalog", "руб."); ?>
                        </p>
                    </div>

                    <?php if (Yii::app()->hasModule('order')): ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default product-quantity-decrease" type="button">-
                                        </button>
                                    </div>
                                    <input type="text" class="text-center form-control" value="1"
                                           name="Product[quantity]" id="product-quantity"/>

                                    <div class="input-group-btn">
                                        <button class="btn btn-default product-quantity-increase" type="button">+
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-success pull-left" id="add-product-to-cart"
                                        data-loading-text="Добавляем">
                                    <?= Yii::t("StoreModule.cart", "Добавить в корзину"); ?>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
                <br>
                <hr>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#description" data-toggle="tab"><?= Yii::t("StoreModule.catalog", "Описание"); ?></a>
    </li>
    <li><a href="#data" data-toggle="tab"><?= Yii::t("StoreModule.catalog", "Данные"); ?></a></li>
    <li><a href="#attributes" data-toggle="tab"><?= Yii::t("StoreModule.catalog", "Характеристики"); ?></a></li>
    <li><a href="#comments-tab" data-toggle="tab"><?= Yii::t("StoreModule.catalog", "Комментарии"); ?></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="description">
        <?= $product->description; ?>
    </div>
    <div class="tab-pane" id="data">
        <?= $product->data; ?>
    </div>
    <div class="tab-pane" id="attributes">
        <table>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Производитель"); ?>:</b></td>
                <td><?= CHtml::encode($product->getProducerName()); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Артикул"); ?>:</b></td>
                <td><?= CHtml::encode($product->sku); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Длина"); ?>:</b></td>
                <td><?= round($product->length, 2); ?> <?= Yii::t("StoreModule.catalog", "м"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Ширина"); ?>:</b></td>
                <td><?= round($product->width, 2); ?> <?= Yii::t("StoreModule.catalog", "м"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Высота"); ?>:</b></td>
                <td><?= round($product->height, 2); ?> <?= Yii::t("StoreModule.catalog", "м"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.catalog", "Вес"); ?>:</b></td>
                <td><?= round($product->weight, 2); ?> <?= Yii::t("StoreModule.catalog", "кг"); ?></td>
            </tr>
        </table>
    </div>
    <div class="tab-pane" id="comments-tab">
        <?php
        $this->widget(
            'application.modules.comment.widgets.CommentsListWidget',
            array(
                'model' => $product,
                'modelId' => $product->id,
                'comments' => $product->comments
            )
        );
        ?>

        <?php
        $this->widget(
            'application.modules.comment.widgets.CommentFormWidget',
            array(
                'redirectTo' => $this->createUrl('/store/catalog/show/', array('name' => $product->name)),
                'model' => $product,
                'modelId' => $product->id,
            )
        );
        ?>
    </div>
</div>
</div>
</div>

<?php Yii::app()->getClientScript()->registerScript(
    "product-images",
    <<<JS
        $(".thumbnails").simpleGal({
    mainImage: "#main-image"
});
JS
);?>
