<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 * @var $form \yupe\widgets\ActiveForm
 * @var ImageGroup $imageGroup
 */
?>
<?php Yii::app()->getClientScript()->registerCssFile($this->getModule()->getAssetsUrl().'/css/store-backend.css'); ?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab"><?= Yii::t("StoreModule.store", "Common"); ?></a></li>
    <li><a href="#attributes" data-toggle="tab"><?= Yii::t("StoreModule.store", "Attributes"); ?></a></li>
    <li><a href="#images" data-toggle="tab"><?= Yii::t("StoreModule.store", "Images"); ?></a></li>
    <li><a href="#variants" data-toggle="tab"><?= Yii::t("StoreModule.store", "Variants"); ?></a></li>
    <li><a href="#stock" data-toggle="tab"><?= Yii::t("StoreModule.store", "Stock"); ?></a></li>
    <li><a href="#seo" data-toggle="tab"><?= Yii::t("StoreModule.store", "SEO"); ?></a></li>
    <li><a href="#linked" data-toggle="tab"><?= Yii::t("StoreModule.store", "Linked products"); ?></a></li>
</ul>

<?php
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
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
    <?= Yii::t('StoreModule.store', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('StoreModule.store', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>


<div class="tab-content">
    <div class="tab-pane active" id="common">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->textFieldGroup($model, 'sku'); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
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
                <?= $form->checkBoxGroup($model, 'is_special'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->dropDownListGroup(
                    $model,
                    'category_id',
                    [
                        'widgetOptions' => [
                            'data' => StoreCategoryHelper::formattedList(),
                            'htmlOptions' => [
                                'empty' => '---',
                                'encode' => false,
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
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
                <?= $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'price'); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'discount_price'); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'discount'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a class="panel-title collapsed" data-toggle="collapse" data-parent="#accordion_price"
                               href="#collapse_price">
                                <?= Yii::t("StoreModule.store", 'Additional price'); ?>
                            </a>
                        </div>
                        <div id="collapse_price" class="panel-collapse collapse" style="height: 0px;">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= $form->textFieldGroup($model, 'purchase_price'); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?= $form->textFieldGroup($model, 'average_price'); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <?= $form->textFieldGroup($model, 'recommended_price'); ?>
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
                    <?php $this->widget(
                        'store.widgets.CategoryTreeWidget',
                        [
                            'selectedCategories' => $model->getCategoriesId(),
                            'id' => 'category-tree',
                        ]
                    ); ?>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-7">
                <div class="preview-image-wrapper<?= !$model->getIsNewRecord() && $model->image ? '' : ' hidden' ?>">
                    <div class="btn-group image-settings">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="collapse"
                                data-target="#image-settings"><span class="fa fa-gear"></span></button>
                        <div id="image-settings" class="dropdown-menu">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?= $form->textFieldGroup($model, 'image_alt'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?= $form->textFieldGroup($model, 'image_title'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?=
                    CHtml::image(
                        !$model->getIsNewRecord() && $model->image ? $model->getImageUrl(200, 200, true) : '#',
                        $model->name,
                        [
                            'class' => 'preview-image img-thumbnail',
                            'style' => !$model->getIsNewRecord() && $model->image ? '' : 'display:none',
                        ]
                    ); ?>
                </div>

                <?php if (!$model->getIsNewRecord() && $model->image): ?>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="delete-file"> <?= Yii::t(
                                'YupeModule.yupe',
                                'Delete the file'
                            ) ?>
                        </label>
                    </div>
                <?php endif; ?>

                <?= $form->fileFieldGroup(
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
            <div class="col-sm-12 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
                <?= $form->labelEx($model, 'description'); ?>
                <?php $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'description',
                    ]
                ); ?>
                <p class="help-block"></p>
                <?= $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12 <?= $model->hasErrors('short_description') ? 'has-error' : ''; ?>">
                <?= $form->labelEx($model, 'short_description'); ?>
                <?php $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'short_description',
                    ]
                ); ?>
                <p class="help-block"></p>
                <?= $form->error($model, 'short_description'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12 <?= $model->hasErrors('data') ? 'has-error' : ''; ?>">
                <?= $form->labelEx($model, 'data'); ?>
                <?php $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'data',
                    ]
                ); ?>
                <p class="help-block"></p>
                <?= $form->error($model, 'data'); ?>
            </div>
        </div>

        <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
        <div class="panel-group" id="template-options">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        <a data-toggle="collapse" data-parent="#template-options" href="#collapse-template">
                            <?= Yii::t('StoreModule.store', 'Templates settings'); ?>
                        </a>
                    </div>
                </div>
                <div id="collapse-template" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-7">
                                <?= $form->textFieldGroup($model, 'view'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>

    </div>

    <div class="tab-pane" id="stock">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'in_stock',
                    [
                        'widgetOptions' => [
                            'data' => $model->getInStockList(),
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->numberFieldGroup($model, 'quantity'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'length'); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'width'); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'height'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <?= $form->textFieldGroup($model, 'weight'); ?>
            </div>
        </div>

    </div>

    <div class="tab-pane" id="images">
        <?php if ($model->getIsNewRecord()): ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="alert alert-success">
                        <?= Yii::t("StoreModule.store", "Mass upload alert"); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row form-group">
            <div class="col-xs-2">
                <?= Yii::t("StoreModule.store", "Images"); ?>
            </div>
            <div class="col-xs-2">
                <button id="button-add-image" type="button" class="btn btn-default"><i class="fa fa-fw fa-plus"></i>
                </button>
            </div>
            <div class="col-sm-3 col-sm-offset-5 text-right">
                <button type="button" data-toggle="modal" data-target="#image-groups" class="btn btn-primary">
                    <?= Yii::t("StoreModule.store", "Image groups"); ?>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <?php $imageModel = new ProductImage(); ?>
                <div id="product-images">
                    <div class="image-template hidden form-group">
                        <div class="row">
                            <div class="col-xs-6 col-sm-2">
                                <label for=""><?= Yii::t("StoreModule.store", "File"); ?></label>
                                <input type="file" class="image-file"/>
                            </div>
                            <div class="col-xs-5 col-sm-3">
                                <label for=""><?= Yii::t("StoreModule.store", "Image title"); ?></label>
                                <input type="text" class="image-title form-control"/>
                            </div>
                            <div class="col-xs-5 col-sm-3">
                                <label for=""><?= Yii::t("StoreModule.store", "Image alt"); ?></label>
                                <input type="text" class="image-alt form-control"/>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <label for=""><?= Yii::t("StoreModule.store", "Group"); ?></label>
                                <?= CHtml::dropDownList('', null, ImageGroupHelper::all(), [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'class' => 'form-control image-group image-group-dropdown',
                                ]) ?>
                            </div>
                            <div class="col-xs-2 col-sm-1" style="padding-top: 24px">
                                <button class="button-delete-image btn btn-default" type="button"><i
                                        class="fa fa-fw fa-trash-o"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!$model->getIsNewRecord() && $model->images): ?>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?= Yii::t("StoreModule.store", "Image title"); ?></th>
                            <th><?= Yii::t("StoreModule.store", "Image alt"); ?></th>
                            <th><?= Yii::t("StoreModule.store", "Group"); ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->images as $image): ?>
                            <tr>
                                <td>
                                    <img src="<?= $image->getImageUrl(100, 100); ?>" alt="" class="img-responsive"/>
                                </td>
                                <td>
                                    <?= CHtml::textField('ProductImage['.$image->id.'][title]', $image->title,
                                        ['class' => 'form-control']) ?>
                                </td>
                                <td>
                                    <?= CHtml::textField('ProductImage['.$image->id.'][alt]', $image->alt,
                                        ['class' => 'form-control']) ?>
                                </td>
                                <td>
                                    <?= CHtml::dropDownList(
                                        'ProductImage['.$image->id.'][group_id]',
                                        $image->group_id,
                                        ImageGroupHelper::all(),
                                        [
                                            'empty' => Yii::t('StoreModule.store', '--choose--'),
                                            'class' => 'form-control image-group-dropdown',
                                        ]
                                    ) ?>
                                </td>
                                <td class="text-center">
                                    <a data-id="<?= $image->id; ?>" href="<?= Yii::app()->createUrl(
                                        '/store/productBackend/deleteImage',
                                        ['id' => $image->id]
                                    ); ?>" class="btn btn-default product-delete-image"><i
                                            class="fa fa-fw fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="attributes">
        <div class="row">
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'type_id',
                    [
                        'widgetOptions' => [
                            'data' => CHtml::listData(Type::model()->findAll(), 'id', 'name'),
                            'htmlOptions' => [
                                'empty' => '---',
                                'encode' => false,
                                'id' => 'product-type',
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div id="attributes-panel">
            <?php $this->renderPartial(
                '_attribute_form',
                ['groups' => $model->getAttributeGroups(), 'model' => $model]
            ); ?>
        </div>
    </div>

    <div class="tab-pane" id="seo">
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'title'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'meta_title'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'meta_keywords'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textAreaGroup($model, 'meta_description'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'meta_canonical'); ?>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="variants">
        <div class="row">
            <div class="col-sm-12 form-group">
                <label class="control-label" for=""><?= Yii::t("StoreModule.store", "Attribute"); ?></label>

                <div class="form-inline">
                    <div class="form-group">
                        <select id="variants-type-attributes" class="form-control"></select>
                        <a href="#" class="btn btn-default" id="add-product-variant"><?= Yii::t(
                                "StoreModule.store",
                                "Add"
                            ); ?></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="variant-template variant">
                        <table>
                            <thead>
                            <tr>
                                <td><?= Yii::t("StoreModule.store", "Attribute"); ?></td>
                                <td><?= Yii::t("StoreModule.store", "Value"); ?></td>
                                <td><?= Yii::t("StoreModule.store", "Price type"); ?></td>
                                <td><?= Yii::t("StoreModule.store", "Price"); ?></td>
                                <td><?= Yii::t("StoreModule.store", "SKU"); ?></td>
                                <td><?= Yii::t("StoreModule.store", "Order"); ?></td>
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

    <div class="tab-pane" id="linked">
        <?php if ($model->getIsNewRecord()): ?>
            <?= Yii::t("StoreModule.store", "First you need to save the product."); ?>
        <?php else: ?>
            <?= $this->renderPartial('_link_form', ['product' => $model, 'searchModel' => $searchModel]); ?>
        <?php endif; ?>
    </div>
</div>

<br/><br/>

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

<?php $this->renderPartial('_image_groups_modal', ['imageGroup' => $imageGroup]) ?>

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

        $('#product-type').on('change', function () {
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

        $('#button-add-image').on('click', function () {
            var newImage = $("#product-images .image-template").clone().removeClass('image-template').removeClass('hidden');
            var key = $.now();

            newImage.appendTo("#product-images");
            newImage.find(".image-file").attr('name', 'ProductImage[new_' + key + '][name]');
            newImage.find(".image-title").attr('name', 'ProductImage[new_' + key + '][title]');
            newImage.find(".image-alt").attr('name', 'ProductImage[new_' + key + '][alt]');
            newImage.find(".image-group").attr('name', 'ProductImage[new_' + key + '][group_id]');

            return false;
        });

        $(this).closest('.product-image').remove();

        $('#product-images').on('click', '.button-delete-image', function () {
            $(this).closest('.row').remove();
        });

        $('.product-delete-image').on('click', function (event) {
            event.preventDefault();
            var blockForDelete = $(this).closest('tr');
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
