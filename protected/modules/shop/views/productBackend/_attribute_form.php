<?php
if (isset($model))
{
    $type = $model->type;
}
?>
<div class="well well-small">
    <?php if (is_array($type->typeAttributes)): ?>
        <?php foreach ($type->typeAttributes as $attribute): ?>
            <div class="row-fluid">
                <div class="span2">
                    <label for="Attribute_<?= $attribute->name ?>"><?php echo $attribute->title; ?></label>
                </div>
                <div class="span10">
                    <?php echo $attribute->renderField($model ? $model->attr($attribute->name) : null); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>