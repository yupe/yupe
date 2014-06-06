<?php
/* @var $product Product */

$this->pageTitle = $product ? ($product->meta_title ? : $product->name) : Yii::t('ShopModule.catalog', 'Product');

$this->description = $product->meta_description;
$this->keywords    = $product->meta_keywords;

$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/style.css');
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.simpleGal.js');
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/shop.js');

$this->breadcrumbs = array_merge(
    array('Каталог' => array('/shop/catalog/index')),
    $product->mainCategory->getBreadcrumbs(true),
    array($product->name)
);

?>
    <div class="row-fluid">
        <div class="span12">
            <div class="span12">
                <span class="title"><?php echo $product->name; ?></span>
            </div>
            <div class="span12 product-feature">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="thumbnails">
                            <div class="image-preview">
                                <img src="<?php echo $product->mainImage->getImageUrl(); ?>" alt="Placeholder" class="" id="main-image">
                            </div>
                            <?php foreach (array_merge(array($product->mainImage), $product->imagesNotMain) as $key => $image): ?>
                                <a href="<?php echo $image->getImageUrl(); ?>">
                                    <img src="<?php echo $image->getImageUrl(50, 50); ?>" alt="Thumbnail">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="span8">
                        <h4><?php echo $product->name; ?></h4>
                        <?php echo $product->in_stock ? "В наличии" : "Нет в наличии"; ?> <br/>
                        <?php echo $product->quantity; ?> items in stock
                        <hr/>
                        <?php foreach ($product->type->typeAttributes as $attribute): ?>
                            <?php echo $attribute->title; ?>: <?php echo $attribute->renderValue($product->attr($attribute->name)); ?> <br/>
                        <?php endforeach; ?>
                        <hr>
                        <?php echo $product->short_description; ?>
                        <hr>
                        <h5>Варианты</h5>

                        <form action="<?php echo Yii::app()->createUrl('shop/cart/add'); ?>" method="post">
                            <input type="hidden" name="Product[id]" value="<?php echo $product->id; ?>"/>
                            <?php echo CHtml::hiddenField(Yii::app()->getRequest()->csrfTokenName, Yii::app()->getRequest()->csrfToken); ?>
                            <table>
                                <?php
                                $variantsGroup = array();
                                $options       = array();
                                foreach ((array)$product->variants as $variant)
                                {
                                    $variantsGroup[$variant->attribute->title][] = $variant;
                                    $options[$variant->id]                       = array('data-type' => $variant->type, 'data-amount' => $variant->amount);
                                };?>
                                <?php foreach ($variantsGroup as $title => $variantsGroup): ?>
                                    <tr>
                                        <td>
                                            <?php echo $title; ?>
                                        </td>
                                        <td>
                                            <?php echo CHtml::dropDownList('ProductVariant[]', null, CHtml::listData($variantsGroup, 'id', 'optionValue'), array('empty' => '', 'options' => $options)); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>
                            <h5>
                                <input type="hidden" id="base-price" value="<?php echo round($product->getResultPrice(), 2); ?>"/>
                                Цена: <?php echo round($product->getBasePrice(), 2); ?> руб. <br/>
                                Фиксированная цена со скидкой: <?php echo round($product->discount_price, 2); ?> руб. <br/>
                                Скидка: <?php echo round($product->discount); ?>% <br/>
                                Итоговая цена: <span id="result-price"><?php echo round($product->getResultPrice(), 2); ?></span> руб.
                            </h5>

                            <div class="row-fluid">
                                <div class="input-prepend input-append span3">
                                    <button class="btn btn-default product-quantity-decrease" type="button">-</button>
                                    <input type="text" class="span5 text-center" value="1" name="Product[quantity]" id="product-quantity"/>
                                    <button class="btn btn-default product-quantity-increase" type="button">+</button>
                                </div>
                                <div class="span6">
                                    <button class="btn btn-success pull-left" id="add-product-to-cart" data-loading-text="Добавляем">Добавить в корзину</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#description" data-toggle="tab">Описание</a></li>
                <li><a href="#data" data-toggle="tab">Данные</a></li>
                <li><a href="#attributes" data-toggle="tab">Характеристики</a></li>
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
                            <td><b>Производитель:</b></td>
                            <td><?php echo $product->producer->name; ?></td>
                        </tr>
                        <tr>
                            <td><b>Артикул:</b></td>
                            <td><?php echo $product->sku; ?></td>
                        </tr>
                        <tr>
                            <td><b>Длина:</b></td>
                            <td><?php echo round($product->length, 2); ?> м</td>
                        </tr>
                        <tr>
                            <td><b>Ширина:</b></td>
                            <td><?php echo round($product->width, 2); ?> м</td>
                        </tr>
                        <tr>
                            <td><b>Высота:</b></td>
                            <td><?php echo round($product->height, 2); ?> м</td>
                        </tr>
                        <tr>
                            <td><b>Вес:</b></td>
                            <td><?php echo round($product->weight, 2); ?> кг</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php Yii::app()->getClientScript()->registerScript("product-images",
    <<<JS
    $(".thumbnails").simpleGal({
    mainImage: "#main-image"
});
JS
);?>