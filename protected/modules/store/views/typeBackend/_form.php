
<?php
/**
 * @var $model Type
 * @var $availableAttributes Attribute[]
 */

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'type-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>


<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>


<div class="row">
    <?php $tree = [];
    $selectedAttributes = [];
    $model->refresh();
    foreach ($model->typeAttributes as $attribute) {
        $selectedAttributes[] = $attribute->id;
    }
    foreach ((array)AttributeGroup::model()->findAll() as $group) {
        $items = [];
        $groupHasNotSelectedAttribute = false;
        $groupItems = (array)$group->groupAttributes;
        foreach ($groupItems as $item) {
            $selected = in_array($item->id, $selectedAttributes);
            if (!$selected) {
                $groupHasNotSelectedAttribute = true;
            }
            $items[] = ['text' => CHtml::tag('div', ['class' => 'checkbox'], CHtml::label(CHtml::checkBox('attributes[]', $selected, ['value' => $item->id]) . $item->title, null))];
        }
        $tree[] = [
            'text' => CHtml::tag(
                'div',
                ['class' => 'checkbox'],
                CHtml::label(CHtml::checkBox('', count($groupItems) && !$groupHasNotSelectedAttribute, ['class' => 'group-checkbox']) . $group->name, null)
            ),
            'children' => $items
        ];
    }
    foreach ((array)Attribute::model()->findAllByAttributes(['group_id' => null]) as $attribute) {
        $tree[] = [
            'text' => CHtml::tag(
                'div',
                ['class' => 'checkbox'],
                CHtml::label(CHtml::checkBox('attributes[]', in_array($attribute->id, $selectedAttributes), ['value' => $attribute->id]) . $attribute->title, null)
            )
        ];
    }
    ?>
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Yii::t("StoreModule.store", "Type attributes"); ?>
            </div>
            <div class="panel-body">
                <?php $this->widget('CTreeView', ['data' => $tree, 'collapsed' => true]); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.store', 'Add type and continue') : Yii::t('StoreModule.store', 'Save type and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.store', 'Add type and close') : Yii::t('StoreModule.store', 'Save type and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
