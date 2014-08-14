<?php
/* @var $product Product */

$this->pageTitle = $product ? ($product->meta_title ?: $product->name) : Yii::t('StoreModule.catalog', 'Product');

$this->description = $product->meta_description;
$this->keywords = $product->meta_keywords;

$mainAssets = Yii::app()->getModule('store')->getAssetsUrl();
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/jquery.simpleGal.js');

$this->breadcrumbs = array_merge(
    array(Yii::t("StoreModule.catalog", 'Каталог') => array('/store/catalog/index')),
    $product->mainCategory->getBreadcrumbs(true),
    array($product->name)
);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <span class="title"><?php echo $product->name; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 product-feature">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="thumbnails">
                            <div class="image-preview">
                                <img src="<?php echo $product->mainImage ? $product->mainImage->getImageUrl() : ''; ?>" alt="" class="" id="main-image">
                            </div>
                            <?php foreach (array_filter(array_merge(array($product->mainImage), $product->imagesNotMain)) as $key => $image): { ?>
                                <a href="<?php echo $image->getImageUrl(); ?>">
                                    <img src="<?php echo $image->getImageUrl(50, 50); ?>"/>
                                </a>
                            <?php } endforeach; ?>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <?php echo $product->in_stock ? Yii::t("StoreModule.catalog", "В наличии") : Yii::t("StoreModule.catalog", "Нет в наличии"); ?>
                        <br/>
                        <?php echo $product->quantity; ?> <?php echo Yii::t("StoreModule.catalog", "в наличии"); ?>
                        <br/>
                        <br/>
                        <div class="properties">
                            <?php
                            // группировка атрибутов по группам
                            $attributeGroups = array();
                            foreach ($product->type->typeAttributes as $attribute) {
                                if ($attribute->group) {
                                    $attributeGroups[$attribute->group->name][] = $attribute;
                                } else {
                                    $attributeGroups[Yii::t('StoreModule.attribute', 'Без группы')][] = $attribute;
                                }
                            }
                            ?>
                            <?php foreach ($attributeGroups as $groupName => $items): { ?>
                                <div class="propertyGroup">
                                    <h4>
                                        <span><?php echo $groupName; ?></span>
                                    </h4>
                                    <table>
                                        <tbody>
                                            <?php foreach ($items as $attribute): { ?>
                                                <tr>
                                                    <td class="key">
                                                        <span><?php echo $attribute->title; ?></span>
                                                    </td>
                                                    <td class="value">
                                                        <?php echo $attribute->renderValue($product->attr($attribute->name)); ?>
                                                    </td>
                                                </tr>
                                            <?php } endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } endforeach; ?>
                        </div>
                        <br/>
                        <h4><?php echo Yii::t("StoreModule.catalog", "Описание"); ?></h4>
                        <?php echo $product->short_description; ?>
                        <hr>
                        <h4><?php echo Yii::t("StoreModule.catalog", "Варианты"); ?></h4>
                        <form action="<?php echo Yii::app()->createUrl('store/cart/add'); ?>" method="post">
                            <input type="hidden" name="Product[id]" value="<?php echo $product->id; ?>"/>
                            <?php echo CHtml::hiddenField(Yii::app()->getRequest()->csrfTokenName, Yii::app()->getRequest()->csrfToken); ?>
                            <table class="table table-condensed">
                                <?php
                                $variantsGroups = array();
                                $options = array();
                                foreach ((array)$product->variants as $variant) {
                                    $variantsGroups[$variant->attribute->title][] = $variant;
                                    $options[$variant->id] = array('data-type' => $variant->type, 'data-amount' => $variant->amount);
                                };?>
                                <?php foreach ($variantsGroups as $title => $variantsGroup): { ?>
                                    <tr>
                                        <td style="padding: 0;">
                                            <?php echo $title; ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::dropDownList(
                                                'ProductVariant[]',
                                                null,
                                                CHtml::listData($variantsGroup, 'id', 'optionValue'),
                                                array('empty' => '', 'options' => $options, 'class' => 'form-control')
                                            ); ?>
                                        </td>
                                    </tr>
                                <?php } endforeach; ?>
                            </table>
                            <h5>
                                <input type="hidden" id="base-price" value="<?php echo round($product->getResultPrice(), 2); ?>"/>
                                <p>
                                    <?php echo Yii::t("StoreModule.catalog", "Цена"); ?>: <?php echo round($product->getBasePrice(), 2); ?> <?php echo Yii::t("StoreModule.catalog", "руб."); ?>
                                </p>
                                <p>
                                    <?php echo Yii::t("StoreModule.catalog", "Фиксированная цена со скидкой"); ?>: <?php echo round($product->discount_price, 2); ?>
                                    <?php echo Yii::t("StoreModule.catalog", "руб."); ?>
                                </p>
                                <p>
                                    <?php echo Yii::t("StoreModule.catalog", "Скидка"); ?>: <?php echo round($product->discount); ?>%
                                </p>
                                <p>
                                    <?php echo Yii::t("StoreModule.catalog", "Итоговая цена"); ?>: <span id="result-price"><?php echo round($product->getResultPrice(), 2); ?></span>
                                    <?php echo Yii::t("StoreModule.catalog", "руб."); ?>
                                </p>
                            </h5>

                            <?php if (Yii::app()->hasModule('order')): ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default product-quantity-decrease" type="button">-</button>
                                            </div>
                                            <input type="text" class="text-center form-control" value="1" name="Product[quantity]" id="product-quantity"/>
                                            <div class="input-group-btn">
                                                <button class="btn btn-default product-quantity-increase" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-success pull-left" id="add-product-to-cart" data-loading-text="Добавляем">
                                            <?php echo Yii::t("OrderModule.cart", "Добавить в корзину"); ?>
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
            <li class="active"><a href="#description" data-toggle="tab"><?php echo Yii::t("StoreModule.catalog", "Описание"); ?></a></li>
            <li><a href="#data" data-toggle="tab"><?php echo Yii::t("StoreModule.catalog", "Данные"); ?></a></li>
            <li><a href="#attributes" data-toggle="tab"><?php echo Yii::t("StoreModule.catalog", "Характеристики"); ?></a></li>
            <li><a href="#comments-tab" data-toggle="tab"><?php echo Yii::t("StoreModule.catalog", "Комментарии"); ?></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="description">
                <?php echo $product->description; ?>
            </div>
            <div class="tab-pane" id="data">
                <?php echo $product->data; ?>
            </div>
            <div class="tab-pane" id="attributes">
                <table>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Производитель"); ?>:</b></td>
                        <td><?php echo $product->producer->name; ?></td>
                    </tr>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Артикул"); ?>:</b></td>
                        <td><?php echo $product->sku; ?></td>
                    </tr>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Длина"); ?>:</b></td>
                        <td><?php echo round($product->length, 2); ?> <?php echo Yii::t("StoreModule.catalog", "м"); ?></td>
                    </tr>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Ширина"); ?>:</b></td>
                        <td><?php echo round($product->width, 2); ?> <?php echo Yii::t("StoreModule.catalog", "м"); ?></td>
                    </tr>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Высота"); ?>:</b></td>
                        <td><?php echo round($product->height, 2); ?> <?php echo Yii::t("StoreModule.catalog", "м"); ?></td>
                    </tr>
                    <tr>
                        <td><b><?php echo Yii::t("StoreModule.catalog", "Вес"); ?>:</b></td>
                        <td><?php echo round($product->weight, 2); ?> <?php echo Yii::t("StoreModule.catalog", "кг"); ?></td>
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
