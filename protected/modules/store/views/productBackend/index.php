<?php
/**
 * @var $this ProductBackendController
 * @var $model Product
 */

$this->layout = 'product';

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Products') => ['/store/productBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Products - manage');
?>
<div class="page-header">
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
                        $categoryList .= '<br>' . $category->name;
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
                'filter' => CHtml::activeTextField($model, 'price', ['class' => 'form-control']),
            ],
            [
                'class' => 'yupe\widgets\EditableStatusColumn',
                'name' => 'status',
                'url' => $this->createUrl('/store/productBackend/inline'),
                'source' => $model->getStatusList(),
                'options' => [
                    Product::STATUS_ACTIVE => ['class' => 'label-success'],
                    Product::STATUS_NOT_ACTIVE => ['class' => 'label-info'],
                    Product::STATUS_ZERO => ['class' => 'label-default'],
                ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
                'buttons' => [
                    'front_view' => [
                        'visible' => function ($row, $data) {
                                return $data->status == Product::STATUS_ACTIVE;
                            }
                    ]
                ]
            ],
        ],
    ]
); ?>

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
JS
); ?>







