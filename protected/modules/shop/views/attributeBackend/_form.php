<?php
$mainAssets = Yii::app()->assetManager->publish(    Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery-sortable.js');
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shop.css');
?>

<?php
/**
 * @var $model Attribute
 */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'attribute-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.attribute', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.attribute', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>'>
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'maxlength' => 250)); ?>
</div>

<div class='control-group <?php echo $model->hasErrors("title") ? "error" : ""; ?>'>
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span7', 'maxlength' => 150)); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("required") ? "error" : ""; ?>'>
    <?php echo $form->checkBoxRow($model, 'required', array('class' => '')); ?>
</div>

<div class='row-fluid control-group <?php echo $model->hasErrors("type") ? "error" : ""; ?>'>
    <?php echo $form->dropDownListRow($model, 'type', $model->getTypesList(), array('class' => 'span7', 'id' => 'attribute-type')); ?>
</div>
<div class="row-fluid control-group">
    <div id="options" class="<?php echo !in_array($model->type, Attribute::getTypesWithOptions()) ? 'hidden' : ''; ?> well span4 ">
        <div class="control-group">
            Опции
        </div>
        <div class="control-group">
            <button id="button-add-option" type="button" class="btn"><i class="icon-plus"></i></button>
        </div>
        <div id="attribute-options" class="form-inline">
            <div class="control-group hidden option-template attribute-option-box">
                <button class="button-move-option btn" type="button"><i class="icon-resize-vertical"></i></button>
                <input type="text" value="" name="" class="option-value"/>
                <button class="button-delete-option btn" type="button"><i class="icon-trash"></i></button>
            </div>
            <?php foreach ($model->options as $option): ?>
                <div class="control-group attribute-option-box">
                    <button class="button-move-option btn" type="button"><i class="icon-resize-vertical"></i></button>
                    <input type="text" value="<?php echo $option->value; ?>" name="AttributeOption[<?php echo $option->id; ?>]" class="option-value" />
                    <button class="button-delete-option btn" type="button"><i class="icon-trash"></i></button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(function () {
        $('#attribute-type').change(function () {
            if ($.inArray(parseInt($(this).val()), [<?php echo join(',', Attribute::getTypesWithOptions());?>]) >= 0) {
                $('#options').removeClass('hidden');
            }
            else {
                $('#options').addClass('hidden');
            }
        });
        $("#attribute-options").sortable({
            itemSelector: '.attribute-option-box',
            group: 'no-drop',
            handle: '.button-move-option',
            onDragStart: function (item, container, _super) {
                // Duplicate items of the no drop area
                if (!container.options.drop)
                    item.clone().insertAfter(item)
                _super(item)
            }
        })

        $('#button-add-option').click(function () {
            var row = $("#attribute-options .option-template").clone().removeClass('option-template').removeClass('hidden');
            row.appendTo("#attribute-options");
            row.find(".option-value").attr('name', 'AttributeOption[]');
            return false;
        });

        $('#options').on('click', '.button-delete-option', function () {
            $(this).parent().remove();
        });
    });
</script>

<br/><br/>




<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type'       => 'primary',
    'label'      => $model->isNewRecord ? Yii::t('ShopModule.attribute', 'Добавить и продолжить') : Yii::t('ShopModule.attribute', 'Сохранить и продолжить'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'  => 'submit',
    'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
    'label'       => $model->isNewRecord ? Yii::t('ShopModule.attribute', 'Добавить и вернуться к списку') : Yii::t('ShopModule.attribute', 'Сохранить и вернуться к списку'),
)); ?>

<?php $this->endWidget(); ?>
