<?php
/* @var $model Product - передается при рендере из формы редактирования товара */
/* @var $type Type - передается при генерации формы через ajax */
?>


<?php if ($model && $model->type): ?>
    <div class="row">
        <div class="col-sm-12">
            <?php if (is_array($model->type->typeAttributes)): ?>
                <?php
                $attributeGroups = [];
                foreach ($model->type->typeAttributes as $attribute) {
                    if ($attribute->group) {
                        $attributeGroups[$attribute->group->name][] = $attribute;
                    } else {
                        $attributeGroups[Yii::t('StoreModule.attribute', 'Without a group')][] = $attribute;
                    }
                }
                ?>
                <?php foreach ($attributeGroups as $groupName => $items): ?>
                    <fieldset>
                        <legend><?php echo $groupName; ?></legend>
                        <?php foreach ($items as $attribute): ?>
                            <?php /* @var $attribute Attribute */ ?>
                            <?php $hasError = isset($model) ? $model->hasErrors('eav.' . $attribute->name) : false; ?>
                            <div class="row form-group">
                                <div class="col-sm-2">
                                    <label for="Attribute_<?= $attribute->name ?>"
                                           class="<?php echo $hasError ? "has-error" : ""; ?>">
                                        <?php echo $attribute->title; ?>
                                        <?php if ($attribute->required): ?>
                                            <span class="required">*</span>
                                        <?php endif; ?>
                                        <?php if ($attribute->unit): ?>
                                            <span>(<?php echo $attribute->unit; ?>)</span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                                <div class="col-sm-<?php echo $attribute->type == Attribute::TYPE_TEXT ? 9 : 2; ?> <?php echo $hasError ? "has-error" : ""; ?>">
                                    <?php echo $attribute->renderField((isset($model) ? $model->attr($attribute->name) : null)); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <?= Yii::t('StoreModule.store', 'Attributes are not added.'); ?>
        <?= CHtml::link(Yii::t('StoreModule.store', 'Add them ?'), ['/store/attributeBackend/create']); ?>
    </div>
<?php endif; ?>
