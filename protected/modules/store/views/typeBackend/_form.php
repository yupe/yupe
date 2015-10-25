<script type="text/javascript">
    $(document).ready(function () {
        function changeChildNodes(elem) {
            $(elem).closest('li').find('input').attr('checked', elem.checked);
        }

        $('.group-checkbox').change(function () {
            changeChildNodes(this);
        });

        // не знаю, зачем так грубо
        $('#type-form').submit(function () {
            var typeForm = $(this);
            $('#category-tree a.jstree-clicked').each(function (index, element) {
                typeForm.append('<input type="hidden" name="categories[]" value="' + $(element).data('category-id') + '" />');
            });
        });

    })
</script>
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
        <?= $form->dropDownListGroup(
            $model,
            'main_category_id',
            [
                'widgetOptions' => [
                    'data' => StoreCategory::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty' => '---',
                        'encode' => false,
                        'id' => 'main_category_id',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>


<div class='row'>
    <div class="col-sm-7 form-group">
        <?= CHtml::activeLabel($model, 'categories'); ?>
        <?php $this->widget('store.widgets.CategoryTreeWidget', ['selectedCategories' => unserialize($model->categories), 'id' => 'category-tree']); ?>
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
                <?= Yii::t("StoreModule.type", "Type attributes"); ?>
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
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.type', 'Add type and continue') : Yii::t('StoreModule.type', 'Save type and continue'),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.type', 'Add type and close') : Yii::t('StoreModule.type', 'Save type and close'),
    ]
); ?>

<?php $this->endWidget(); ?>
