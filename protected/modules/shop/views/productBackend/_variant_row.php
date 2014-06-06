<?php
/* @var $variant ProductVariant */
$new = false;
if (!$variant->id)
{
    $new         = true;
    $variant->id = rand(10000, 50000);
}?>
<tr>
    <?php if (!$new): ?>
        <input type="hidden" name="ProductVariant[<?php echo $variant->id; ?>][id]" value="<?php echo $variant->id; ?>"/>
    <?php endif; ?>
    <td>
        <?php echo $variant->attribute->title; ?>
        <input type="hidden" value="<?php echo $variant->attribute_id; ?>" name="ProductVariant[<?php echo $variant->id; ?>][attribute_id]"/>
    </td>
    <td>
        <?php //echo CHtml::dropDownList('ProductVariant['.$variant->id.'][option_id]', $variant->option_id, CHtml::listData($variant->attribute->options, 'id', 'value'));?>

        <?php
        if ($variant->attribute->type == Attribute::TYPE_DROPDOWN)
        {
            echo $variant->attribute->renderField($variant->option_id, 'ProductVariant[' . $variant->id . '][option_id]');
        }
        else
        {
            echo $variant->attribute->renderField($variant->value, 'ProductVariant[' . $variant->id . '][value]');
        }
        ?>
    </td>
    <td>
        <?php echo CHtml::dropDownList('ProductVariant[' . $variant->id . '][type]', $variant->type, $variant->getTypeList()); ?>
    </td>
    <td><input type="text" name="ProductVariant[<?php echo $variant->id; ?>][amount]" value="<?php echo $variant->amount; ?>"></td>
    <td><input type="text" name="ProductVariant[<?php echo $variant->id; ?>][sku]" value="<?php echo $variant->sku; ?>"></td>
    <td><a href="#" class="btn btn-mini remove-variant">Удалить</a></td>
</tr>