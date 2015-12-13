<?php /* @var $model OrderProduct */
$new = false;
$product = $model->product;
$productExists = !is_null($product);
$hasVariants = $productExists && !empty($product->variants);

if (!$model->id) {
    $new = true;
    $model->id = 'new-' . rand(10000, 50000);
    $model->price = $product->getResultPrice();
    $model->quantity = 1;
}
$id = $model->id;
?>

<tr class="product-row">
    <td>
        <?php if (!$new): ?>
            <input type="hidden" name="OrderProduct[<?= $id; ?>][id]" value="<?= $id; ?>"/>
        <?php endif; ?>
        <?php if ($productExists): ?>
            <input type="hidden" class="product-base-price" value="<?= $product->getResultPrice(); ?>"/>
            <input type="hidden" name="OrderProduct[<?= $id; ?>][product_id]"
                   value="<?= $product->id; ?>"/>
            <img src="<?= $product->getImageUrl(40, 40); ?>" alt="" class="img-thumbnail"/>
        <?php endif; ?>
    </td>
    <td <?php if (!$hasVariants): ?> colspan="2" <?php endif; ?>>
        <?php if ($productExists): ?>
            <?= CHtml::link($model->product_name ?: $product->name, ['/store/productBackend/update', 'id' => $product->id]); ?>
            <br/>
            [<?= $product->getResultPrice(); ?><?= Yii::t("OrderModule.order", Yii::app()->getModule('store')->currency); ?>]
        <?php else: ?>
            <?= $model->product_name; ?>
        <?php endif; ?>
    </td>
    <?php if ($hasVariants): ?>
    <td>
        <?php if ($productExists): ?>
            <?php
            $variantGroups = [];
            $variantGroupsSelected = [];
            $options = [];
            $orderProductVariants = $model->variantsArray;
            foreach ((array)$product->variants as $variant) {
                $variantGroups[$variant->attribute->title][] = $variant;
                $options[$variant->id] = ['data-type' => $variant->type, 'data-amount' => $variant->amount];

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
                $options[$var['id']] = ['data-type' => $var['type'], 'data-amount' => $var['amount'], 'class' => 'muted'];
            }
            ?>
            <?php foreach ($variantGroups as $title => $variantGroup): ?>
                <div class="row">
                    <div class="col-sm-5">
                        <?= $title; ?>
                    </div>
                    <div class="col-sm-7">
                        <?= CHtml::dropDownList(
                            'OrderProduct[' . $id . '][variant_ids][]',
                            isset($variantGroupsSelected[$title]) ? $variantGroupsSelected[$title] : null,
                            CHtml::listData($variantGroup, 'id', 'optionValue'),
                            ['empty' => '', 'options' => $options, 'class' => 'form-control product-variant']
                        ); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted"><?= Yii::t("OrderModule.order", "Product deleted"); ?></p>
        <?php endif; ?>
    </td>
    <?php endif; ?>
    <td>
        <?= CHtml::activeTextField($model, 'quantity', ['class' => 'form-control product-quantity', 'name' => 'OrderProduct[' . $id . '][quantity]']); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, 'price', ['class' => 'form-control product-price', 'name' => 'OrderProduct[' . $id . '][price]']); ?>
    </td>
    <td>
        <a href="#" class="btn btn-sm btn-danger remove-product"><i class="fa fa-fw fa-times"></i></a>
    </td>
</tr>