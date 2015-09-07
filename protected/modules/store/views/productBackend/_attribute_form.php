<?php
/* @var $model Product - передается при рендере из формы редактирования товара */
/* @var $type Type - передается при генерации формы через ajax */
?>

<?php if (!empty($groups)): ?>
    <div class="row">
        <div class="col-sm-12">
                <?php foreach ($groups as $groupName => $items): ?>
                    <fieldset>
                        <legend><?= CHtml::encode($groupName); ?></legend>
                        <?php foreach ($items as $attribute): ?>
                            <?php /* @var $attribute Attribute */ ?>
                            <?php $hasError = $model->hasErrors('eav.' . $attribute->name); ?>
                            <div class="row form-group">
                                <div class="col-sm-2">
                                    <label for="Attribute_<?= $attribute->name ?>"
                                           class="<?= $hasError ? "has-error" : ""; ?>">
                                        <?= $attribute->title; ?>
                                        <?php if ($attribute->required): ?>
                                            <span class="required">*</span>
                                        <?php endif; ?>
                                        <?php if ($attribute->unit): ?>
                                            <span>(<?= $attribute->unit; ?>)</span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                                <div class="col-sm-<?= $attribute->isType(Attribute::TYPE_TEXT) ? 9 : 2; ?> <?= $hasError ? "has-error" : ""; ?>">
                                    <?php $htmlOptions = $attribute->isType(Attribute::TYPE_CHECKBOX) ? [] : ['class' => 'form-control']; ?>
                                    <?= $attribute->renderField($model->attribute($attribute->name), null, $htmlOptions); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <?= Yii::t('StoreModule.store', 'Attributes are not added.'); ?>
        <?= CHtml::link(Yii::t('StoreModule.store', 'Add them ?'), ['/store/attributeBackend/create']); ?>
    </div>
<?php endif; ?>
