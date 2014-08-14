<?php
/* @var $model Product */
if (isset($model)) {
    $type = $model->type;
}
?>
<div class="row">
    <div class="col-sm-12">
        <?php if (is_array($type->typeAttributes)): { ?>
            <?php
            $attributeGroups = array();
            foreach ($type->typeAttributes as $attribute) {
                if ($attribute->group) {
                    $attributeGroups[$attribute->group->name][] = $attribute;
                } else {
                    $attributeGroups[Yii::t('StoreModule.attribute', 'Без группы')][] = $attribute;
                }
            }
            ?>
            <?php foreach ($attributeGroups as $groupName => $items): { ?>
                <fieldset>
                    <legend><?php echo $groupName; ?></legend>
                    <?php foreach ($items as $attribute): { ?>
                        <?php $hasError = $model ? $model->hasErrors('eav.' . $attribute->name) : false; ?>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label for="Attribute_<?= $attribute->name ?>" class="<?php echo $hasError ? "has-error" : ""; ?>">
                                    <?php echo $attribute->title; ?>
                                    <?php if ($attribute->required): { ?>
                                        <span class="required">*</span>
                                    <?php } endif; ?>
                                    <?php if ($attribute->unit): { ?>
                                        <span>(<?php echo $attribute->unit; ?>)</span>
                                    <?php } endif; ?>
                                </label>
                            </div>
                            <div class="col-sm-2 <?php echo $hasError ? "has-error" : ""; ?>">
                                <?php echo $attribute->renderField($model ? $model->attr($attribute->name) : null); ?>
                            </div>
                        </div>
                    <?php } endforeach; ?>
                </fieldset>
            <?php } endforeach; ?>
        <?php } endif; ?>
    </div>
</div>
