<?php
/* @var $searchModel ProductSearch */
/* @var $product Product */

if (!isset($searchModel)) {
    $searchModel = new ProductSearch('search');
    $searchModel->unsetAttributes();
}

$linkTypes = ProductLinkType::getFormattedList();

?>

<?php if (isset($product)): ?>
    <div class="row">
        <div class="col-sm-12">
            <?php
            $linked = new ProductLink('search');
            $linked->setAttributes(Yii::app()->getRequest()->getParam('ProductLink'));
            $linked->product_id = $product->id;
            $this->widget(
                'yupe\widgets\CustomGridView',
                [
                    'id' => 'linked-product-grid',
                    'type' => 'condensed',
                    'dataProvider' => $linked->search(),
                    'filter' => $linked,
                    'hideBulkActions' => true,
                    'ajaxUrl' => ['/store/productBackend/update', 'id' => $product->id],
                    'columns' => [
                        [
                            'name' => 'id',
                            'value' => function ($data) {
                                return $data->linkedProduct->id;
                            },
                            'filter' => false,
                        ],
                        [
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::image($data->linkedProduct->getImageUrl(40, 40), "", ["class" => "img-thumbnail"]);
                            },
                        ],
                        [
                            'header' => Yii::t('StoreModule.store', 'Name'),
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link($data->linkedProduct->name, ["/store/productBackend/update", "id" => $data->linkedProduct->id]);
                            },
                        ],
                        [
                            'header' => Yii::t('StoreModule.product', 'SKU'),
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link($data->linkedProduct->sku, ["/store/productBackend/update", "id" => $data->linkedProduct->id]);
                            },
                        ],
                        [
                            'header' => Yii::t('StoreModule.product', 'Price'),
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->linkedProduct->price;
                            },
                        ],
                        [
                            'class' => 'yupe\widgets\EditableStatusColumn',
                            'name' => 'type_id',
                            'url' => $this->createUrl('/store/linkBackend/inline'),
                            'source' => $linkTypes,
                            'options' => [

                            ],
                        ],
                        [
                            'class' => 'yupe\widgets\CustomButtonColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => [
                                    'url' => function ($data) {
                                        return Yii::app()->createUrl('/store/link/delete', ['id' => $data->id]);
                                    }
                                ]
                            ]
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <?php

        $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'product-grid',
                'type' => 'condensed',
                'dataProvider' => $searchModel->search(),
                'filter' => $searchModel,
                'hideBulkActions' => true,
                'ajaxUrl' => ['/store/linkBackend/index'],
                'columns' => [
                    [
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::image($data->getImageUrl(40, 40), "", ["class" => "img-thumbnail"]);
                        },
                    ],
                    [
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link($data->name, ["/store/productBackend/update", "id" => $data->id]);
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
                        'filter' => CHtml::activeTextField($searchModel, 'sku', ['class' => 'form-control']),
                    ],
                    [
                        'name' => 'category_id',
                        'value' => function ($data) {
                            $categoryList = '<span class="label label-primary">' . (isset($data->mainCategory) ? $data->mainCategory->name : '---') . '</span>';

                            foreach ($data->categories as $category) {
                                $categoryList .= '<br>' . $category->name;
                            }

                            return $categoryList;
                        },
                        'type' => 'raw',
                        'filter' => CHtml::activeDropDownList($searchModel, 'category', StoreCategory::model()->getFormattedList(), ['encode' => false, 'empty' => '', 'class' => 'form-control']),
                        'htmlOptions' => ['width' => '220px'],
                    ],
                    [
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'name' => 'price',
                        'value' => function ($data) {
                            return (float)$data->price;
                        },
                        'editable' => [
                            'url' => $this->createUrl('/store/productBackend/inline'),
                            'mode' => 'inline',
                            'params' => [
                                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                            ]
                        ],
                        'filter' => CHtml::activeTextField($searchModel, 'price', ['class' => 'form-control']),
                    ],
                    [
                        'value' => function ($data) use ($linkTypes) {
                            $links = [];

                            foreach ($linkTypes as $id => $name) {
                                $links[] = [
                                    'label' => $name,
                                    'linkOptions' => ['class' => 'link-product-button', 'data-type-id' => $id, 'data-linked-product-id' => $data->id,],
                                    'url' => '#',
                                ];
                            }

                            return $this->widget(
                                'booster.widgets.TbButtonGroup',
                                [
                                    'buttons' => [
                                        [
                                            'label' => Yii::t('StoreModule.product', 'Add in'),
                                            'items' => $links,
                                        ]
                                    ],
                                ],
                                true
                            );
                        },
                        'type' => 'raw',
                    ]
                ],
            ]
        ); ?>
    </div>
</div>

<?php
$productId = isset($product) ? $product->id : null;
$linkUrl = Yii::app()->createUrl('/store/linkBackend/link');
$tokenName = Yii::app()->getRequest()->csrfTokenName;
$token = Yii::app()->getRequest()->csrfToken;
Yii::app()->getClientScript()->registerScript(__FILE__, <<<JS
    $('body').on('click', '.link-product-button', function (e) {
        e.preventDefault();
        var button = $(this);
        var data = {
            product_id: $productId,
            linked_product_id: button.data('linked-product-id'),
            type_id: button.data('type-id'),
            "$tokenName": "$token"
        };
        $.ajax({
            url: "$linkUrl",
            type: 'post',
            data: data,
            success: function(data){
                $.fn.yiiGridView.update('linked-product-grid');
            }
        });
    })
JS
); ?>

