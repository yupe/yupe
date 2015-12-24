<?php
/* @var $searchModel ProductSearch */
/* @var $product Product */

$linkTypes = CHtml::listData(ProductLinkType::model()->findAll(['order' => 'title ASC']), 'id', 'title');
?>


<div class="row">
    <div class="col-sm-12">
        <h3><?= Yii::t('StoreModule.store', 'Products related with "{name}"', ['{name}' => $product->name]); ?></h3>
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
                'actionsButtons' => false,
                'bulkActions' => [false],
                'ajaxUrl' => ['/store/productBackend/update', 'id' => $product->id],
                'columns' => [
                    [
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link(
                                CHtml::image(
                                    $data->linkedProduct->getImageUrl(40, 40),
                                    $data->linkedProduct->name,
                                    ["class" => "img-thumbnail"]
                                ),
                                ["/store/productBackend/update", "id" => $data->linkedProduct->id]
                            );
                        },
                    ],
                    [
                        'header' => Yii::t('StoreModule.store', 'Name'),
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link(
                                $data->linkedProduct->name,
                                ["/store/productBackend/update", "id" => $data->linkedProduct->id]
                            );
                        },
                    ],
                    [
                        'header' => Yii::t('StoreModule.store', 'SKU'),
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link(
                                $data->linkedProduct->sku,
                                ["/store/productBackend/update", "id" => $data->linkedProduct->id]
                            );
                        },
                    ],
                    [
                        'header' => Yii::t('StoreModule.store', 'Price'),
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
                        'value' => function ($data) {
                            return $data->type->title;
                        },
                    ],
                    [
                        'class' => 'yupe\widgets\CustomButtonColumn',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => [
                                'url' => function ($data) {
                                    return Yii::app()->createUrl('/store/linkBackend/delete', ['id' => $data->id]);
                                },
                            ],
                        ],
                    ],
                ],
            ]
        ); ?>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <h3><?= Yii::t('StoreModule.store', 'Link products'); ?></h3>
        <?php

        $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'product-grid',
                'type' => 'condensed',
                'dataProvider' => $searchModel->searchNotFor(isset($product->id) ? $product->id : null),
                'filter' => $searchModel,
                'actionsButtons' => false,
                'bulkActions' => [false],
                'ajaxUrl' => ['/store/linkBackend/index'],
                'columns' => [
                    [
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link(
                                CHtml::image($data->getImageUrl(40, 40), $data->name, ["class" => "img-thumbnail"]),
                                ["/store/productBackend/update", "id" => $data->id]
                            );
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
                                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
                            ],
                        ],
                        'filter' => CHtml::activeTextField($searchModel, 'sku', ['class' => 'form-control']),
                    ],
                    [
                        'name' => 'category_id',
                        'value' => function ($data) {
                            $categoryList = '<span class="label label-primary">'.(isset($data->category) ? $data->category->name : '---').'</span>';

                            foreach ($data->categories as $category) {
                                $categoryList .= '<br>'.$category->name;
                            }

                            return $categoryList;
                        },
                        'type' => 'raw',
                        'filter' => CHtml::activeDropDownList(
                            $searchModel,
                            'category',
                            StoreCategoryHelper::formattedList(),
                            ['encode' => false, 'empty' => '', 'class' => 'form-control']
                        ),
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
                                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
                            ],
                        ],
                        'filter' => CHtml::activeTextField($searchModel, 'price', ['class' => 'form-control']),
                    ],
                    [
                        'value' => function ($data) use ($linkTypes) {
                            $links = [];
                            foreach ($linkTypes as $id => $name) {
                                $links[] = [
                                    'label' => $name,
                                    'linkOptions' => [
                                        'class' => 'link-product-button',
                                        'data-type-id' => $id,
                                        'data-linked-product-id' => $data->id,
                                    ],
                                    'url' => '#',
                                ];
                            }

                            return $this->widget(
                                'booster.widgets.TbButtonGroup',
                                [
                                    'buttons' => [
                                        [
                                            'label' => Yii::t('StoreModule.store', 'Add in'),
                                            'items' => $links,
                                        ],
                                    ],
                                ],
                                true
                            );
                        },
                        'type' => 'raw',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('click', '.link-product-button', function (e) {
            e.preventDefault();
            var button = $(this);
            var data = {
                product_id: <?= isset($product) ? $product->id : null;?>,
                linked_product_id: button.data('linked-product-id'),
                type_id: button.data('type-id'),
                "<?= Yii::app()->getRequest()->csrfTokenName;?>": "<?= Yii::app()->getRequest()->csrfToken; ?>"
            };
            $.ajax({
                url: "<?= Yii::app()->createUrl('/store/linkBackend/link');?>",
                type: 'post',
                data: data,
                success: function (data) {
                    $.fn.yiiGridView.update('linked-product-grid');
                }
            });
        })
    });
</script>
