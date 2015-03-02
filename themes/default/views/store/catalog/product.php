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
    [Yii::t("StoreModule.store", 'Catalog') => ['/store/catalog/index']],
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
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            <a href="<?= $product->getImageUrl(); ?>" class="thumbnail">
                                <img src="<?= $product->getImageUrl(50, 50); ?>"/>
                            </a>
                        </div>
                        <?php foreach ($product->getImages() as $key => $image): { ?>
                            <div class="col-xs-4 col-md-4">
                                <a href="<?= $image->getImageUrl(); ?>" class="thumbnail">
                                    <img src="<?= $image->getImageUrl(50, 50); ?>"/>
                                </a>
                            </div>
                        <?php } endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <?= $product->isInStock() ? Yii::t("StoreModule.product", "In stock") : Yii::t(
                    "StoreModule.product",
                    "Not in stock"
                ); ?>
                <br/>
                <?= $product->quantity; ?> <?= Yii::t("StoreModule.product", "in stock"); ?>
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
                <h4><?= Yii::t("StoreModule.store", "Description"); ?></h4>
                <?= $product->short_description; ?>
                <hr>
                <h4><?= Yii::t("StoreModule.store", "Variants"); ?></h4>

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
                                        ['empty' => '', 'class' => 'form-control', 'options' => $product->getVariantsOptions()]
                                    ); ?>
                                </td>
                            </tr>
                        <?php } endforeach; ?>
                    </table>
                    <div>
                        <input type="hidden" id="base-price" value="<?= round($product->getResultPrice(), 2); ?>"/>

                        <p>
                            <?= Yii::t("StoreModule.product", "Price"); ?>
                            : <?= round($product->getBasePrice(), 2); ?> <?= Yii::t("StoreModule.product", "RUB"); ?>
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.product", "Fix price with discount"); ?>
                            : <?= round($product->getDiscountPrice(), 2); ?>
                            <?= Yii::t("StoreModule.product", "RUB"); ?>
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.product", "Discount"); ?>: <?= round($product->discount); ?>%
                        </p>

                        <p>
                            <?= Yii::t("StoreModule.product", "Total price"); ?>: <span
                                id="result-price"><?= round($product->getResultPrice(), 2); ?></span>
                            <?= Yii::t("StoreModule.product", "RUB"); ?>
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
                                        data-loading-text="<?= Yii::t("StoreModule.store", "Adding"); ?>">
                                    <?= Yii::t("StoreModule.store", "Add to cart"); ?>
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
    <li class="active"><a href="#description" data-toggle="tab"><?= Yii::t("StoreModule.store", "Description"); ?></a>
    </li>
    <li><a href="#data" data-toggle="tab"><?= Yii::t("StoreModule.store", "Data"); ?></a></li>
    <li><a href="#attributes" data-toggle="tab"><?= Yii::t("StoreModule.store", "Characteristics"); ?></a></li>
    <li><a href="#comments-tab" data-toggle="tab"><?= Yii::t("StoreModule.store", "Comments"); ?></a></li>
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
                <td><b><?= Yii::t("StoreModule.producer", "Producer"); ?>:</b></td>
                <td><?= CHtml::encode($product->getProducerName()); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.product", "SKU"); ?>:</b></td>
                <td><?= CHtml::encode($product->sku); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.product", "Length"); ?>:</b></td>
                <td><?= round($product->length, 2); ?> <?= Yii::t("StoreModule.product", "m"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.product", "Width"); ?>:</b></td>
                <td><?= round($product->width, 2); ?> <?= Yii::t("StoreModule.product", "m"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.product", "Height"); ?>:</b></td>
                <td><?= round($product->height, 2); ?> <?= Yii::t("StoreModule.product", "m"); ?></td>
            </tr>
            <tr>
                <td><b><?= Yii::t("StoreModule.product", "Weight"); ?>:</b></td>
                <td><?= round($product->weight, 2); ?> <?= Yii::t("StoreModule.product", "kg"); ?></td>
            </tr>
        </table>
    </div>
    <div class="tab-pane" id="comments-tab">
        <?php
        $this->widget(
            'application.modules.comment.widgets.CommentsListWidget',
            [
                'model' => $product,
                'modelId' => $product->id,
                'comments' => $product->comments
            ]
        );
        ?>

        <?php
        $this->widget(
            'application.modules.comment.widgets.CommentFormWidget',
            [
                'redirectTo' => $this->createUrl('/store/catalog/show/', ['name' => $product->name]),
                'model' => $product,
                'modelId' => $product->id,
            ]
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
