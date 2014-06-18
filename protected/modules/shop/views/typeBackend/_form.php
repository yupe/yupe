<?php
$mainAssets = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('application.modules.shop.views.assets')
);
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery-sortable.js');
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shop.css');
?>

<?php
/**
 * @var $model Type
 * @var $availableAttributes Attribute[]
 */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'type-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.type', 'Поля помеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.type', 'обязательны'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 250)); ?>
</div>
<?php $categoriesList = (new ShopCategory())->getTabList(); ?>
<div class='row-fluid control-group <?php echo $model->hasErrors("main_category_id") ? "error" : ""; ?>'>
    <?php echo $form->dropDownListRow($model, 'main_category_id', $categoriesList, array('class' => 'span7', 'id' => 'main_category_id')); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("categories") ? "error" : ""; ?>'>
    <?php echo CHtml::activeLabel($model, 'categories'); ?>
    <?php
    $this->widget('application.modules.shop.widgets.CategoryTreeWidget', array('selectedCategories' => unserialize($model->categories), 'id' => 'category-tree'));
    ?>
</div>

<div class="row-fluid control-group">
    <div id="type-attributes">
        <div class="span3">
            <p>Атрибуты товара</p>
            <ol class="type-attributes" id="new-type-attributes">
                <?php foreach ($model->typeAttributes as $attribute): ?>
                    <li>
                        <input type="hidden" name="attributes[]" value="<?php echo $attribute->id; ?>"/>
                        <span><i class="icon-move"></i> <?php echo $attribute->title; ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
        <div class="span3">
            <p>Доступные атрибуты</p>
            <ol class="type-attributes">
                <?php foreach ($availableAttributes ? : array() as $attribute): ?>
                    <li>
                        <input type="hidden" name="" value="<?php echo $attribute->id; ?>"/>
                        <span><i class="icon-move"></i> <?php echo $attribute->title; ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        $("ol.type-attributes ").sortable({
            group: 'type-attributes',
            onDragStart: function ($item, container, _super) {
                $item.find('ol').sortable('disable');
                _super($item, container);
            },
            onDrop: function ($item, container, _super) {
                $item.find('ol').sortable('enable');
                _super($item, container);

                var input = $item.find('input[type="hidden"]');
                if ($item.parent().attr('id') == 'new-type-attributes') {
                    input.attr('name', 'attributes[]');
                }
                else {
                    input.attr('name', '');
                }
            }
        });
        $('#type-form').submit(function () {
            var typeForm = $(this);
            $('#category-tree a.jstree-clicked').each(function(index, element){
                typeForm.append('<input type="hidden" name="categories[]" value="' + $(element).data('category-id') + '" />');
            });
        });
    });
</script>

<br/><br/>




<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => $model->isNewRecord ? Yii::t('ShopModule.type', 'Добавить и продолжить') : Yii::t('ShopModule.type', 'Сохранить и продолжить'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'  => 'submit',
    'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
    'label'       => $model->isNewRecord ? Yii::t('ShopModule.type', 'Добавить и вернуться к списку') : Yii::t('ShopModule.type', 'Сохранить и вернуться к списку'),
)); ?>

<?php $this->endWidget(); ?>
