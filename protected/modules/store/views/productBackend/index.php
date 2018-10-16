<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 * @var $form ActiveForm
 * @var $batchModel ProductBatchForm
 */

use yupe\widgets\ActiveForm;

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Products') => ['/store/productBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Products - manage');
?>
<div>
    <h1>
        <?= Yii::t('StoreModule.store', 'Products'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id' => 'product-grid',
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'position',
        'sortableAction'    => '/store/productBackend/sortable',
        'type' => 'condensed',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'actionsButtons' => [
            'add' => CHtml::link(
                Yii::t('StoreModule.store', 'Add'),
                ['/store/productBackend/create'],
                ['class' => 'btn btn-sm btn-success pull-right']
            ),
            'copy' => CHtml::link(
                Yii::t('StoreModule.store', 'Copy'),
                '#',
                ['id' => 'copy-products', 'class' => 'btn btn-sm btn-default pull-right', 'style' => 'margin-right: 4px;']
            ),
            'batch' => CHtml::button(Yii::t('StoreModule.store', 'Batch actions'), [
                'class' => 'btn btn-sm btn-primary pull-right',
                'style' => 'margin-right:7px',
                'data-toggle' => 'modal',
                'data-target' => '#batch-actions',
            ]),
        ],
        'columns' => [
            [
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::image(StoreImage::product($data, 40, 40), $data->name, ["width" => 40, "height" => 40, "class" => "img-thumbnail"]);
                },
            ],
            [
                'name' => 'name',
                'type' => 'raw',
                'value' => function ($data) {
                        return CHtml::link(\yupe\helpers\YText::wordLimiter($data->name, 5), ["/store/productBackend/update", "id" => $data->id]);
                    },
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'sku',
                'editable' => [
                    'emptytext' => '---',
                    'url' => $this->createUrl('/store/productBackend/inline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'sku', ['class' => 'form-control']),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'producer_id',
                'url' => $this->createUrl('/store/productBackend/inline'),
                'source' => CMap::mergeArray(
                    ['' => '---'],
                    Producer::model()->getFormattedList()
                ),
                'editable' => [
                    'emptytext' => '---',
                ],
            ],
            [
                'name'  => 'category_id',
                'value' => function($data){
                    $categoryList = '<span class="label label-primary">'. (isset($data->category) ? $data->category->name : '---') . '</span>';

                    foreach ($data->categories as $category) {
                        $categoryList .= '</span>&nbsp;<span class="label label-default">' . $category->name .'</span>';
                    }

                    return $categoryList;
                },
                'type' => 'raw',
                'filter' => CHtml::activeDropDownList($model, 'category_id', StoreCategoryHelper::formattedList(), ['encode' => false, 'empty' => '', 'class' => 'form-control']),
                'htmlOptions' => ['width' => '220px'],
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'price',
                'value' => function (Product $data) {
                    return round($data->getBasePrice(), 2);
                },
                'editable' => [
                    'url' => $this->createUrl('/store/productBackend/inline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'price', ['class' => 'form-control']),
            ],

            [
                'class'  => 'bootstrap.widgets.TbEditableColumn',
                'name'   => 'discount_price',
                'header' => Yii::t('StoreModule.store', 'New price'),
                'value' => function (Product $data) {
                    return round($data->getDiscountPrice(), 2);
                },
                'editable' => [
                    'emptytext' => '---',
                    'url' => $this->createUrl('/store/productBackend/inline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'discount_price', ['class' => 'form-control']),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'in_stock',
                'header' => Yii::t('StoreModule.store', 'Availability'),
                'url' => $this->createUrl('/store/productBackend/inline'),
                'source' => $model->getInStockList(),
                'options' => [
                    Product::STATUS_IN_STOCK => ['class' => 'label-success'],
                    Product::STATUS_NOT_IN_STOCK => ['class' => 'label-danger']
                ],
            ],
            [
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'quantity',
                'value' => function (Product $data) {
                    return $data->quantity;
                },
                'header' => Yii::t('StoreModule.store', 'Rest'),
                'editable' => [
                    'url' => $this->createUrl('/store/productBackend/inline'),
                    'mode' => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter' => CHtml::activeTextField($model, 'quantity', ['class' => 'form-control']),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/store/productBackend/inline'),
                'source' => $model->getStatusList(),
                'options' => [
                    Product::STATUS_ACTIVE => ['class' => 'label-success'],
                    Product::STATUS_NOT_ACTIVE => ['class' => 'label-info'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'frontViewButtonUrl' => function($data){
                    return ProductHelper::getUrl($data);
                },
                'template' => '{front_view} {view} {update} {images} {delete}',
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                            return $data->status == Product::STATUS_ACTIVE;
                        }
                    ],
                    'images' => [
                        'icon' => 'fa fa-fw fa-picture-o',
                        'label' => Yii::t('StoreModule.store', 'Images'),
                        'url' => function ($data) {
                            return Yii::app()->createUrl('/store/productImageBackend/index', ['id' => $data->id]);
                        },
                        'options' => [
                            'class' => 'images btn btn-sm btn-default',
                        ]
                    ],
                ]
            ],
        ],
    ]
); ?>

<div class="modal fade" id="batch-actions" tabindex="-1" role="dialog" aria-labelledby="batchActions">
    <div class="modal-dialog" role="document">
        <?php
        $form = $this->beginWidget(
            '\yupe\widgets\ActiveForm',
            [
                'id' => 'batch-actions-form',
                'action' => ['/store/productBackend/batch'],
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'type' => 'vertical',
            ]
        ); ?>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="batchActions">
                    <?= Yii::t('StoreModule.store', 'Batch actions') ?>
                </h4>
            </div>
            <div class="modal-body">
                <div id="no-product-selected" class="alert alert-danger hidden">
                    <?= Yii::t('StoreModule.store', 'No one product selected') ?>
                </div>
                <div id="batch-action-error" class="alert alert-danger hidden">
                    <?= Yii::t('StoreModule.store', 'Something going wrong. Sorry.') ?>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <?= $form->label($batchModel, 'price') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->dropDownList($batchModel, 'price_op', ProductBatchHelper::getPericeOpList(), ['class' => 'form-control']) ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->textField($batchModel, 'price', ['class' => 'form-control']) ?>
                            <?= $form->error($batchModel, 'price') ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->dropDownList($batchModel, 'price_op_unit', ProductBatchHelper::getOpUnits(), ['class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <?= $form->label($batchModel, 'discount_price') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->dropDownList($batchModel, 'discount_price_op', ProductBatchHelper::getPericeOpList(), ['class' => 'form-control']) ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->textField($batchModel, 'discount_price', ['class' => 'form-control']) ?>
                            <?= $form->error($batchModel, 'discount_price') ?>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?= $form->dropDownList($batchModel, 'discount_price_op_unit', ProductBatchHelper::getOpUnits(), ['class' => 'form-control']) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->textFieldGroup($batchModel, 'discount') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->textFieldGroup($batchModel, 'quantity') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->dropDownListGroup($batchModel, 'producer_id', [
                            'widgetOptions' => [
                                'data' => Producer::model()->getFormattedList(),
                                'htmlOptions' => [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'encode' => false,
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->dropDownListGroup($batchModel, 'category_id', [
                            'widgetOptions' => [
                                'data' => StoreCategoryHelper::formattedList(),
                                'htmlOptions' => [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'encode' => false,
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->dropDownListGroup($batchModel, 'status', [
                            'widgetOptions' => [
                                'data' => $model->getStatusList(),
                                'htmlOptions' => [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'encode' => false,
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->dropDownListGroup($batchModel, 'in_stock', [
                            'widgetOptions' => [
                                'data' => $model->getInStockList(),
                                'htmlOptions' => [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'encode' => false,
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->dropDownListGroup($batchModel, 'is_special', [
                            'widgetOptions' => [
                                'data' => [
                                    1 => Yii::t('StoreModule.store', 'Yes'),
                                    0 => Yii::t('StoreModule.store', 'No'),
                                ],
                                'htmlOptions' => [
                                    'empty' => Yii::t('StoreModule.store', '--choose--'),
                                    'encode' => false,
                                ],
                            ],
                        ]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->textFieldGroup($batchModel, 'view') ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?= Yii::t('StoreModule.store', 'Close') ?>
                </button>
                <button type="submit" id="batch-apply" class="btn btn-success">
                    <?= Yii::t('StoreModule.store', 'Apply') ?>
                </button>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
$url = Yii::app()->createUrl('/store/productBackend/copy');
$tokenName = Yii::app()->getRequest()->csrfTokenName;
$token = Yii::app()->getRequest()->csrfToken;
Yii::app()->getClientScript()->registerScript(
    __FILE__,
    <<<JS
    $('body').on('click', '#copy-products', function (e) {
        e.preventDefault();
        var checked = $.fn.yiiGridView.getCheckedRowsIds('product-grid');
        if (!checked.length) {
            alert('No items are checked');
            return false;
        }
        if(confirm("Вы уверены, что хотите дублировать выбранные элементы?")){
            var url = "$url";
            var data = {};
            data['$tokenName'] = "$token";
            data['items'] = checked;
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.result) {
                        $.fn.yiiGridView.update("product-grid");
                    } else {
                        alert(data.data);
                    }
                },
                error: function (data) {alert("Ошибка!")}
            });
        }
    });

    $('#batch-actions-form').on('submit', function(e) {
        e.preventDefault();
        
        var checked = $.fn.yiiGridView.getCheckedRowsIds('product-grid');
        $('#batch-action-error').addClass('hidden');
        
        if (checked.length == 0) {
            return false;
        }

        var data = $(this).serialize() + '&ids=' + checked;

        data['$tokenName'] = "$token";

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {
                if (data.result === true) {
                    $.fn.yiiGridView.update("product-grid");
                    $('#batch-actions').modal('hide');
                }
                
                if (data.result === false) {
                    $('#batch-action-error').removeClass('hidden');
                }
            },
            error: function(data) {
              
            }
        });
    });
    
    $('#batch-actions').on('show.bs.modal', function(e) {
        var checked = $.fn.yiiGridView.getCheckedRowsIds('product-grid');
        
        if (checked.length > 0) {
            return true;
        }
        
        $('#no-product-selected').removeClass('hidden');
        $('#batch-apply').attr('disabled', true);
        
    }).on('hidden.bs.modal', function(e) {
        $('#no-product-selected').addClass('hidden');
        $('#batch-apply').attr('disabled', false);
    });
JS
); ?>







