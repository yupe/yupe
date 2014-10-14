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
    array(
        'id' => 'type-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('StoreModule.type', 'Поля помеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('StoreModule.type', 'обязательны'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'main_category_id',
            array(
                'widgetOptions' => array(
                    'data' => (new StoreCategory())->getTabList(),
                    'htmlOptions' => array(
                        'empty' => '---',
                        'id' => 'main_category_id',
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>


<div class='row'>
    <div class="col-sm-7 form-group">
        <?php echo CHtml::activeLabel($model, 'categories'); ?>
        <?php $this->widget('store.widgets.CategoryTreeWidget', array('selectedCategories' => unserialize($model->categories), 'id' => 'category-tree')); ?>
    </div>
</div>

<div class="row">
    <?php $tree = array();
    $selectedAttributes = array();
    $model->refresh();
    foreach ($model->typeAttributes as $attribute) {
        $selectedAttributes[] = $attribute->id;
    }
    foreach ((array)AttributeGroup::model()->findAll() as $group) {
        $items = array();
        $groupHasNotSelectedAttribute = false;
        $groupItems = (array)$group->groupAttributes;
        foreach ($groupItems as $item) {
            $selected = in_array($item->id, $selectedAttributes);
            if (!$selected) {
                $groupHasNotSelectedAttribute = true;
            }
            $items[] = array('text' => CHtml::tag('div', array('class' => 'checkbox'), CHtml::label(CHtml::checkBox('attributes[]', $selected, array('value' => $item->id)) . $item->title, null)));
        }
        $tree[] = array(
            'text' => CHtml::tag(
                'div',
                array('class' => 'checkbox'),
                CHtml::label(CHtml::checkBox('', count($groupItems) && !$groupHasNotSelectedAttribute, array('class' => 'group-checkbox')) . $group->name, null)
            ),
            'children' => $items
        );
    }
    foreach ((array)Attribute::model()->findAllByAttributes(array('group_id' => null)) as $attribute) {
        $tree[] = array(
            'text' => CHtml::tag(
                'div',
                array('class' => 'checkbox'),
                CHtml::label(CHtml::checkBox('attributes[]', in_array($attribute->id, $selectedAttributes), array('value' => $attribute->id)) . $attribute->title, null)
            )
        );
    }
    ?>
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo Yii::t("StoreModule.type", "Атрибуты типа"); ?>
            </div>
            <div class="panel-body">
                <?php $this->widget('CTreeView', array('data' => $tree, 'collapsed' => true)); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.type', 'Добавить и продолжить') : Yii::t('StoreModule.type', 'Сохранить и продолжить'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.type', 'Добавить и вернуться к списку') : Yii::t('StoreModule.type', 'Сохранить и вернуться к списку'),
    )
); ?>

<?php $this->endWidget(); ?>
