<?php
/* @var $variant ProductVariant */
$new = false;
if (!$variant->id) {
    $new = true;
    $variant->id = rand(10000, 50000);
} ?>
<tr>
    <?php if (!$new): ?>
        <input type="hidden" name="ProductVariant[<?php echo $variant->id; ?>][id]" value="<?php echo $variant->id; ?>"/>
    <?php endif; ?>
    <td>
        <?php echo $variant->attribute->title; ?>
        <input type="hidden" value="<?php echo $variant->attribute_id; ?>" name="ProductVariant[<?php echo $variant->id; ?>][attribute_id]"/>
    </td>
    <td>
        <?php if ($variant->attribute->type == Attribute::TYPE_DROPDOWN): ?>
            <?php
            $option = AttributeOption::model()->findByAttributes(['attribute_id' => $variant->attribute_id, 'value' => $variant->attribute_value]);
            echo $variant->attribute->renderField(($option ? $option->id : null), 'ProductVariant[' . $variant->id . '][attribute_option_id]');
            ?>
        <?php else: ?>
            <?php echo $variant->attribute->renderField($variant->attribute_value, 'ProductVariant[' . $variant->id . '][attribute_value]'); ?>
        <?php endif; ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('ProductVariant[' . $variant->id . '][type]', $variant->type, $variant->getTypeList(), ['class' => 'form-control']); ?>
    </td>
    <td><input class="form-control" type="text" name="ProductVariant[<?php echo $variant->id; ?>][amount]" value="<?php echo $variant->amount; ?>"></td>
    <td><input class="form-control" type="text" name="ProductVariant[<?php echo $variant->id; ?>][sku]" value="<?php echo $variant->sku; ?>"></td>
    <td><a href="#" class="btn btn-danger btn-sm remove-variant">Удалить</a></td>
</tr>
