<?php
/* @var $model Product */
if (isset($model))
{
    $type = $model->type;
}
?>
<div class="well well-small">
    <?php if (is_array($type->typeAttributes)): ?>
        <?php foreach ($type->typeAttributes as $attribute): ?>
            <?php $hasError = $model ? $model->hasErrors('eav.' . $attribute->name): false; ?>
            <div class="row-fluid control-group">
                <div class="span2">
                    <label for="Attribute_<?= $attribute->name ?>" class="<?php echo $hasError ? "error" : ""; ?>" >
                        <?php echo $attribute->title; ?>
                        <?php if($attribute->required):?>
                            <span class="required">*</span>
                        <?php endif;?>
                    </label>
                </div>
                <div class=" span10 <?php echo $hasError ? "error" : ""; ?>">
                    <?php echo $attribute->renderField($model ? $model->attr($attribute->name) : null); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>