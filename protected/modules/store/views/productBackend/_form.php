<?php Yii::app()->getClientScript()->registerCssFile($this->module->getAssetsUrl() . '/css/store-backend.css'); ?>

<script type='text/javascript'>
    $(document).ready(function () {
        $('#product-form').liTranslit({
            elName: '#Product_name',
            elAlias: '#Product_alias'
        });
    })
</script>

<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "Общие"); ?></a></li>
    <li><a href="#stock" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "Склад"); ?></a></li>
    <li><a href="#images" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "Изображения"); ?></a></li>
    <li><a href="#attributes" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "Атрибуты"); ?></a></li>
    <li><a href="#variants" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "Варианты"); ?></a></li>
    <li><a href="#seo" data-toggle="tab"><?php echo Yii::t("StoreModule.store", "SEO"); ?></a></li>
</ul>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'product-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['enctype' => 'multipart/form-data', 'class' => 'well'],
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('StoreModule.store', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('StoreModule.store', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>


<div class="tab-content">
<div class="tab-pane active" id="common">
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data' => $model->getStatusList(),
                    ],
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <br/>
            <?php echo $form->checkBoxGroup($model, 'is_special'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'type_id',
                [
                    'widgetOptions' => [
                        'data' => Type::model()->getFormattedList(),
                        'htmlOptions' => [
                            'empty' => '---',
                            'encode' => false,
                            'id' => 'product-type',
                        ],
                    ]
                ]
            ); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->dropDownListGroup(
                $model,
                'category_id',
                [
                    'widgetOptions' => [
                        'data' => CHtml::listData(
                                StoreCategory::model()->findAll(['order' => 'name DESC']),
                                'id',
                                'name'
                            ),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->dropDownListGroup(
                $model,
                'producer_id',
                [
                    'widgetOptions' => [
                        'data' => Producer::model()->getFormattedList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'alias'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'price'); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'discount_price'); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'discount'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-7">
            <div class="panel-group" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="panel-title collapsed" data-toggle="collapse" data-parent="#accordion_price" href="#collapse_price">
                            <?= Yii::t("StoreModule.store", 'Additional price');?>
                        </a>
                    </div>
                    <div id="collapse_price" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <?php echo $form->textFieldGroup($model, 'purchase_price'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->textFieldGroup($model, 'average_price'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo $form->textFieldGroup($model, 'recommended_price'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
    <div class='row'>
          <div class="col-sm-12">&nbsp;</div>
    </div>
    <div class='row'>
        <div class="col-sm-7">
            <div class="form-group">
                <?php echo CHtml::label(
                    Yii::t("StoreModule.store", 'Дополнительные категории'),
                    null,
                    ['class' => 'control-label']
                ); ?>
                <?php $this->widget(
                    'store.widgets.CategoryTreeWidget',
                    [
                        'selectedCategories' => $model->getCategoriesIdList(),
                        'id' => 'category-tree'
                    ]
                ); ?>
            </div>
        </div>
    </div>




    <div class='row'>
        <div class="col-sm-7">
            <?php
            echo CHtml::image(
                !$model->getIsNewRecord() && $model->image ? $model->getImageUrl() : '#',
                $model->name,
                [
                    'class' => 'preview-image img-thumbnail',
                    'style' => !$model->getIsNewRecord() && $model->image ? '' : 'display:none'
                ]
            ); ?>
            <?php echo $form->fileFieldGroup(
                $model,
                'image',
                [
                    'widgetOptions' => [
                        'htmlOptions' => [
                            'onchange' => 'readURL(this);',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model' => $model,
                    'attribute' => 'description',
                ]
            ); ?>
            <p class="help-block"></p>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-12 <?php echo $model->hasErrors('short_description') ? 'has-error' : ''; ?>">
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model' => $model,
                    'attribute' => 'short_description',
                ]
            ); ?>
            <p class="help-block"></p>
            <?php echo $form->error($model, 'short_description'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-12 <?php echo $model->hasErrors('data') ? 'has-error' : ''; ?>">
            <?php echo $form->labelEx($model, 'data'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model' => $model,
                    'attribute' => 'data',
                ]
            ); ?>
            <p class="help-block"></p>
            <?php echo $form->error($model, 'data'); ?>
        </div>
    </div>
</div>

<div class="tab-pane" id="stock">
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'sku'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'in_stock',
                [
                    'widgetOptions' => [
                        'data' => $model->getInStockList(),
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'length'); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'width'); ?>
        </div>
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'height'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">
            <?php echo $form->textFieldGroup($model, 'weight'); ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->numberFieldGroup($model, 'quantity'); ?>
        </div>
    </div>

</div>

<div class="tab-pane" id="images">
    <div class="row form-group">
        <div class="col-sm-2">
            <?php echo Yii::t("StoreModule.store", "Изображения"); ?>
        </div>
        <div class="col-sm-2">
            <button id="button-add-image" type="button" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row">
        <?php $imageModel = new ProductImage(); ?>
        <div id="product-images">
            <div class="image-template hidden form-group">
                <div class="row">
                    <div class="col-sm-3">
                        <label for=""><?php echo Yii::t("StoreModule.store", "Файл"); ?></label>
                        <input type="file" class="image-file"/>
                    </div>
                    <div class="col-sm-2">
                        <label for=""><?php echo Yii::t("StoreModule.store", "Заголовок"); ?></label>
                        <input type="text" class="image-title form-control"/>
                    </div>
                    <div class="col-sm-1" style="padding-top: 24px">
                        <button class="button-delete-image btn btn-default" type="button"><i
                                class="fa fa-fw fa-trash-o"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!$model->getIsNewRecord()): ?>
            <?php foreach ($model->images as $image): ?>

                <div class="product-image">
                    <div>
                        <img src="<?php echo $image->getImageUrl(150, 150, true); ?>" alt="" class="img-thumbnail"/>
                    </div>
                    <div>
                        <a data-id="<?= $image->id; ?>" href="<?php echo Yii::app()->createUrl(
                            '/store/productBackend/deleteImage',
                            ['id' => $image->id]
                        ); ?>" class="pull-right product-delete-image"><i class="fa fa-fw fa-times"></i></a>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="tab-pane" id="attributes">
    <div id="attributes-panel">
        <?php $this->renderPartial('_attribute_form', ['model' => $model]); ?>
    </div>
</div>

<div class="tab-pane" id="seo">
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'meta_title'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'meta_keywords'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textAreaGroup($model, 'meta_description'); ?>
        </div>
    </div>
</div>

<div class="tab-pane" id="variants">
    <div class="row">
        <div class="col-sm-12 form-group">
            <label class="control-label" for=""><?php echo Yii::t("StoreModule.store", "Атрибут"); ?></label>

            <div class="form-inline">
                <div class="form-group">
                    <select id="variants-type-attributes" class="form-control"></select>
                    <a href="#" class="btn btn-default" id="add-product-variant"><?php echo Yii::t(
                            "StoreModule.store",
                            "Добавить"
                        ); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="variant-template variant form-inline">
                <table>
                    <thead>
                    <tr>
                        <td><?php echo Yii::t("StoreModule.store", "Атрибут"); ?></td>
                        <td><?php echo Yii::t("StoreModule.store", "Значение"); ?></td>
                        <td><?php echo Yii::t("StoreModule.store", "Тип стоимости"); ?></td>
                        <td><?php echo Yii::t("StoreModule.store", "Стоимость"); ?></td>
                        <td><?php echo Yii::t("StoreModule.store", "Артикул"); ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody id="product-variants">
                    <?php foreach ((array)$model->variants as $variant): ?>
                        <?php $this->renderPartial('_variant_row', ['variant' => $variant]); ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.store', 'Add product and continue') : Yii::t(
                'StoreModule.store',
                'Save product and continue'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('StoreModule.store', 'Add product and close') : Yii::t(
                'StoreModule.store',
                'Save product and close'
            ),
    ]
); ?>

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
            if (typeId) {
                $.getJSON('<?= Yii::app()->createUrl('/store/productBackend/typeAttributes');?>/' + typeId, function (data) {
                    typeAttributes = data;
                    var select = $('#variants-type-attributes');
                    select.html("");
                    $.each(data, function (key, value) {
                        select.append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.title));
                    });
                });
            }
        }

        updateVariantTypeAttributes();

        $("#add-product-variant").click(function (e) {
            e.preventDefault();
            var attributeId = $('#variants-type-attributes').val();
            var variantAttribute = typeAttributes.filter(function (el) {
                return el.id == attributeId;
            }).pop();
            var tbody = $('#product-variants');
            $.get('<?= Yii::app()->createUrl('/store/productBackend/variantRow');?>/' + attributeId, function (data) {
                tbody.append(data);
            });
        });

        $('#product-variants').on('click', '.remove-variant', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
        $('#product-type').change(function () {
            var typeId = $(this).val();
            if (typeId) {
                $('#attributes-panel').load('<?= Yii::app()->createUrl('/store/productBackend/typeAttributesForm');?>/' + typeId);
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

        $(this).closest('.product-image').remove();

        $('#product-images').on('click', '.button-delete-image', function () {
            $(this).closest('.row').remove();
        });

        $('.product-delete-image').click(function (event) {
            event.preventDefault();
            var deleteUrl = $(this).attr('href');
            var blockForDelete = $(this).closest('.product-image');
            $.ajax({
                type: "POST",
                data: {
                    'id': $(this).data('id'),
                    '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>'
                },
                url: '<?= Yii::app()->createUrl('/store/productBackend/deleteImage');?>',
                success: function () {
                    blockForDelete.remove();
                }
            });
        });

        function activateFirstTabWithErrors() {
            var tab = $('.has-error').parents('.tab-pane').first();
            if (tab.length) {
                var id = tab.attr('id');
                $('a[href="#' + id + '"]').tab('show');
            }
        }

        activateFirstTabWithErrors();
    });
</script>
