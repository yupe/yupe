<?php
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.shop.views.assets'), false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shop.css');


?>

<script type='text/javascript'>
    $(document).ready(function () {
        $('#product-form').liTranslit({
            elName: '#Product_name',
            elAlias: '#Product_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors' => true,
)); ?>

<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.product', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.product', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab">Общие</a></li>
    <li><a href="#stock" data-toggle="tab">Склад</a></li>
    <li><a href="#images" data-toggle="tab">Изображения</a></li>
    <li><a href="#attributes" data-toggle="tab">Атрибуты</a></li>
    <li><a href="#variants" data-toggle="tab">Варианты</a></li>
    <li><a href="#seo" data-toggle="tab">SEO</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane active" id="common">
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('is_special')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
        <div class="span3">
            <br/><br/>
            <?php echo $form->checkBoxRow($model, 'is_special', array('class' => '', 'data-original-title' => $model->getAttributeLabel('is_special'), 'data-content' => $model->getAttributeDescription('is_special'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('type_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'type_id', Type::model()->getFormattedList(), array('empty' => Yii::t('ShopModule.product', '--choose--'), 'class' => 'span7 ', 'encode' => false, 'id' => 'product-type')); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('producer_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'producer_id', Producer::model()->getFormattedList(), array('empty' => Yii::t('ShopModule.product', '--choose--'), 'class' => 'span7', 'data-original-title' => $model->getAttributeLabel('producer_id'), 'data-content' => $model->getAttributeDescription('producer_id'), 'encode' => false)); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7 ', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7 ', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('price') ? 'error' : ''; ?>">
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'price', array('class' => '', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('price'), 'data-content' => $model->getAttributeDescription('price'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'discount_price', array('class' => '', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('discount_price'), 'data-content' => $model->getAttributeDescription('discount_price'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'discount', array('class' => '', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('discount'), 'data-content' => $model->getAttributeDescription('discount'))); ?>
        </div>
    </div>
    <?php $categoriesList = (new Category())->getTabList(); ?>
    <div class='row-fluid control-group'>
        <label for="categories_main">Главная категория</label>
        <?php echo CHtml::dropDownList('categories[main]', $model->mainCategory->id, $categoriesList, array('class' => 'span7')); ?>
    </div>

    <div class='row-fluid control-group'>
        <?php echo CHtml::label('Дополнительные категории', 'categories'); ?>
        <?php
        $this->widget('application.modules.shop.widgets.CategoryTreeWidget', array('selectedCategories' => $model->getCategoriesIdList(), 'id' => 'category-tree'));
        ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'description',
                'options' => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('short_description') ? 'error' : ''; ?>">
        <div class="" data-original-title='<?php echo $model->getAttributeLabel('short_description'); ?>' data-content='<?php echo $model->getAttributeDescription('short_description'); ?>'>
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'short_description',
                'options' => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('data') ? 'error' : ''; ?>">
        <div class="" data-original-title='<?php echo $model->getAttributeLabel('data'); ?>' data-content='<?php echo $model->getAttributeDescription('data'); ?>'>
            <?php echo $form->labelEx($model, 'data'); ?>
            <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'data',
                'options' => $this->module->editorOptions,
            )); ?>
        </div>
    </div>

</div>
<div class="tab-pane" id="stock">
    <div class="row-fluid control-group <?php echo $model->hasErrors('sku') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'sku', array('class' => 'span7 ', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('sku'), 'data-content' => $model->getAttributeDescription('sku'))); ?>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'length', array('class' => '', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('length'), 'data-content' => $model->getAttributeDescription('length'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'width', array('class' => '', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('width'), 'data-content' => $model->getAttributeDescription('width'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'height', array('class' => '', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('height'), 'data-content' => $model->getAttributeDescription('height'))); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <?php echo $form->textFieldRow($model, 'weight', array('class' => '', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('weight'), 'data-content' => $model->getAttributeDescription('weight'))); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">
            <?php echo $form->dropDownListRow($model, 'in_stock', $model->getInStockList(), array('class' => '', 'data-original-title' => $model->getAttributeLabel('in_stock'), 'data-content' => $model->getAttributeDescription('in_stock'))); ?>
        </div>
        <div class="span2">
            <?php echo $form->numberFieldRow($model, 'quantity', array('class' => '', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('quantity'), 'data-content' => $model->getAttributeDescription('quantity'))); ?>
        </div>
    </div>
</div>
<div class="tab-pane" id="images">
    <div class="row-fluid control-group">
        <div class="control-group">
            Изображения
        </div>
        <div class="control-group">
            <button id="button-add-image" type="button" class="btn"><i class="icon-plus"></i></button>
        </div>
        <?php $imageModel = new ProductImage(); ?>
        <div id="product-images" class="well well-small">
            <div class="image-template hidden control-group">
                <div class="row-fluid">
                    <div class="span3">
                        <label for="">Файл</label>
                        <input type="file" class="image-file"/>
                    </div>
                    <div class="span2">
                        <label for="">Заголовок</label>
                        <input type="text" class="image-title"/>
                    </div>
                    <div class="span1" style="padding-top: 24px">
                        <button class="button-delete-image btn" type="button"><i class="icon-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!$model->isNewRecord): ?>
            <?php foreach ($model->images as $image): ?>

                <div class="product-image">
                    <div>
                        <img src="<?php echo $image->getImageUrl(150, 150, true); ?>" alt="" class="img-polaroid"/>
                    </div>
                    <div>
                        <label for="product-image-<?php echo $image->id; ?>">
                            <input type="radio" name="main_image" value="<?php echo $image->id; ?>" id="product-image-<?php echo $image->id; ?>" <?php echo $image->is_main ? 'checked' : ''; ?>/>
                            Главное
                        </label>
                        <a href="<?php echo Yii::app()->createUrl('/shop/productBackend/deleteImage', array('id' => $image->id)); ?>" class="pull-right product-delete-image"><i class="icon-remove"></i></a>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="tab-pane" id="attributes">
    <div class="row-fluid control-group" id="attributes-panel">
        <?php $this->renderPartial('_attribute_form', array('model' => $model)); ?>
    </div>

</div>
<div class="tab-pane" id="seo">
    <div class="row-fluid control-group <?php echo $model->hasErrors('meta_title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'meta_title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 ', 'data-original-title' => $model->getAttributeLabel('meta_title'), 'data-content' => $model->getAttributeDescription('meta_title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('meta_keywords') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'meta_keywords', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 ', 'data-original-title' => $model->getAttributeLabel('meta_keywords'), 'data-content' => $model->getAttributeDescription('meta_keywords'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('meta_description') ? 'error' : ''; ?>">
        <?php echo $form->textAreaRow($model, 'meta_description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 ', 'data-original-title' => $model->getAttributeLabel('meta_description'), 'data-content' => $model->getAttributeDescription('meta_description'))); ?>
    </div>
</div>

<div class="tab-pane" id="variants">
    <div class="row-fluid">
        <div class="control-group">
            <label class="control-label" for="">Атрибут</label>

            <div class="form-inline">
                <select id="variants-type-attributes">
                </select>
                <a href="#" class="btn" id="add-product-variant">Добавить</a>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div>
            <div class="variant-template variant form-inline">
                <table>
                    <thead>
                    <tr>
                        <td>Атрибут</td>
                        <td>Значение</td>
                        <td>Тип стоимости</td>
                        <td>Стоимость</td>
                        <td>Артикул</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody id="product-variants">
                    <?php foreach ((array)$model->variants as $variant): ?>
                        <?php $this->renderPartial('_variant_row', array('variant' => $variant));?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>


<br/><br/>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? Yii::t('ShopModule.product', 'Add product and continue') : Yii::t('ShopModule.product', 'Save product and continue'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
    'label' => $model->isNewRecord ? Yii::t('ShopModule.product', 'Add product and close') : Yii::t('ShopModule.product', 'Save product and close'),
)); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function () {
        $('#product-form').submit(function () {
            var productForm = $(this);
            $('#category-tree a.jstree-clicked').each(function (index, element) {
                productForm.append('<input type="hidden" name="categories[]" value="' + $(element).data('category-id') + '" />');
            });
        });

        var typeAttributes = {};

        function updateVariantTypeAttributes() {
            var typeId = $('#product-type').val();
            $.getJSON('/backend/shop/product/typeAttributes/' + typeId, function (data) {
                typeAttributes = data;
                var select = $('#variants-type-attributes');
                $.each(data, function (key, value) {
                    select.append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.title));
                });
            });
        }

        updateVariantTypeAttributes();

        $("#add-product-variant").click(function (e) {
            e.preventDefault();
            var attributeId = $('#variants-type-attributes').val();
            var variantAttribute = typeAttributes.filter(function (el) {
                return el.id == attributeId;
            }).pop();
            var tbody = $('#product-variants');
            //$('#attributes-panel').load('/backend/shop/product/typeAttributesForm/' + typeId);
            $.get('/backend/shop/product/variantRow/' + attributeId, function(data){
                tbody.append(data);
            });
            return;
            var text = "<tr>";
            var randomKey = Math.random();
            text += "<td>" + variantAttribute.title + "<input type='hidden' value='" + variantAttribute.id + "' name='ProductVariant[" + randomKey + "][attribute_id]'/>" + "</td>";
            if (variantAttribute.options.length) {
                var tmp = "<select name='ProductVariant[" + randomKey + "][option_id]'>";
                $.each(variantAttribute.options, function (key, el) {
                    console.log(el);
                    tmp += "<option value='" + el.id + "'>" + el.value + "</option>";
                });
                tmp += "</select>";

                text += "<td>" + tmp + "</td>";
            }
            else {
                text += "<td><input type='text'></td>";
            }
            text += '<td><select name="ProductVariant[' + randomKey + '][type]"><option value="0">Сумма</option><option value="1">Процент</option></select></td>';
            text += '<td><input type="text" name="ProductVariant[' + randomKey + '][amount]"/></td>';
            text += '<td><input type="text" name="ProductVariant[' + randomKey + '][sku]"/></td>';
            text += '<td><a href="#" class="btn btn-mini remove-variant">Удалить</a></td>';
            text += "</tr>";
            tbody.append(text);
        });

        $('#product-variants').on('click', '.remove-variant', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
        $('#product-type').change(function () {
            var typeId = $(this).val();
            if (typeId) {
                $('#attributes-panel').load('/backend/shop/product/typeAttributesForm/' + typeId);
                updateVariantTypeAttributes();
            }
            else {
                $('#attributes-panel').html('');
                $('#variants-type-attributes').html('');
            }
        });

        $('#button-add-image').click(function () {
            var newImage = $("#product-images .image-template").clone().removeClass('image-template').removeClass('hidden');
            newImage.appendTo("#product-images");
            newImage.find(".image-file").attr('name', 'ProductImage[][name]');
            newImage.find(".image-title").attr('name', 'ProductImage[][title]');
            return false;
        });

        $('#product-images').on('click', '.button-delete-image', function () {
            $(this).parent().remove();
        });

        $('.product-delete-image').click(function (event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');
            var blockForDelete = $(this).closest('.product-image');
            $.ajax({
                type: "GET",
                url: deleteUrl,
                success: function () {
                    blockForDelete.remove();
                }
            });
        });
    });
</script>