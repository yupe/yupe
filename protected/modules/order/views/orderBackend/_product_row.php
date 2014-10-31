<?php /* @var $model OrderProduct */
$new = false;
$product = $model->product;
$productExists = !is_null($product);

if (!$model->id) {
    $new = true;
    $model->id = 'new-' . rand(10000, 50000);
    $model->price = $product->getResultPrice();
    $model->quantity = 1;
}
$id = $model->id;
?>

<div class="row product-row">
    <div class="col-sm-1">
        <?php if (!$new): ?>
            <input type="hidden" name="OrderProduct[<?php echo $id; ?>][id]" value="<?php echo $id; ?>"/>
        <?php endif; ?>
        <?php if ($product): ?>
            <input type="hidden" class="product-base-price" value="<?php echo $product->getResultPrice(); ?>"/>
            <input type="hidden" name="OrderProduct[<?php echo $id; ?>][product_id]" value="<?php echo $product->id; ?>"/>
            <img src="<?= $product->getImageUrl(40, 40); ?>" alt="" class="img-thumbnail"/>
        <?php endif; ?>
    </div>
    <div class="col-sm-3">
        <?php echo CHtml::link($model->product_name ?: $product->name, array('/store/productBackend/update', 'id' => $product->id)); ?>
        <br/>
        [<?php echo $product->getResultPrice(); ?> <?php echo Yii::t("OrderModule.order", "руб."); ?>]
    </div>
    <div class="col-sm-3">
        <?php if ($product): ?>
            <div class="row">
                <?php
                $variantGroups = array();
                $variantGroupsSelected = array();
                $options = array();
                $orderProductVariants = $model->variantsArray;
                //var_dump($orderProductVariants); die();
                foreach ((array)$product->variants as $variant) {
                    $variantGroups[$variant->attribute->title][] = $variant;
                    $options[$variant->id] = array('data-type' => $variant->type, 'data-amount' => $variant->amount);

                    /* выясняем какие из выбранных вариантов в покупке еще существуют, если эти варианты уже удалили, то позже их все равно добавим в список*/
                    $varFound = false;
                    foreach ($orderProductVariants as $opKey => $opVar) {
                        if ($opVar['id'] == $variant->id) {
                            $varFound = true;
                            break;
                        }
                    }
                    if ($varFound) {
                        $variantGroupsSelected[$variant->attribute->title] = $orderProductVariants[$opKey]['id'];
                        unset($orderProductVariants[$opKey]);
                    }
                }

                /* варианты, которых уже нет в базе */
                foreach ($orderProductVariants as $key => $var) {
                    $var['optionValue'] = '[Удален] ' . $var['optionValue'];
                    $variantGroups[$var['attribute_title']][] = $var;
                    $variantGroupsSelected[$var['attribute_title']] = $var['id'];
                    $options[$var['id']] = array('data-type' => $var['type'], 'data-amount' => $var['amount'], 'class' => 'muted');
                }
                ?>
                <?php foreach ($variantGroups as $title => $variantGroup): ?>
                    <div class="row">
                        <div class="col-sm-5">
                            <?php echo $title; ?>
                        </div>
                        <div class="col-sm-7">
                            <?php echo CHtml::dropDownList(
                                'OrderProduct[' . $id . '][variant_ids][]',
                                isset($variantGroupsSelected[$title]) ? $variantGroupsSelected[$title] : null,
                                CHtml::listData($variantGroup, 'id', 'optionValue'),
                                array('empty' => '', 'options' => $options, 'class' => 'form-control product-variant')
                            ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="muted"><?php echo Yii::t("OrderModule.order", "Продукт удален"); ?></p>
        <?php endif; ?>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-6">
                <div class="input-group">
                    <?php echo CHtml::activeTextField($model, 'price', array('class' => 'form-control product-price', 'name' => 'OrderProduct[' . $id . '][price]')); ?>
                    <span class="input-group-addon">
                        <?php echo Yii::t("OrderModule.order", "руб."); ?>
                    </span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
                    <?php echo CHtml::activeTextField($model, 'quantity', array('class' => 'form-control product-quantity', 'name' => 'OrderProduct[' . $id . '][quantity]')); ?>
                    <span class="input-group-addon">
                        <?php echo Yii::t("OrderModule.order", "шт."); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-1 text-right">
        <a href="#" class="btn btn-default btn-sm  btn-danger remove-product"><i class="fa fa-fw fa-times"></i></a>
    </div>
</div>
