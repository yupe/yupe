<?php
$this->layout = 'product';
$this->pageTitle = Yii::t('StoreModule.store', 'Images');

$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Products') => ['/store/productBackend/index'],
    $product->name => ['/store/productBackend/update', 'id' => $product->id],
    $this->pageTitle,
];

$mainAssets = Yii::app()->assetManager->publish(
    Yii::getPathOfAlias('gallery.views.assets')
);

Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/fileupload.locale.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/fileupload.css');
Yii::app()->clientScript->registerCss(
    'dragndrop-content',
    '.dragndrop:after { content: "' . Yii::t('GalleryModule.gallery', 'Move images here') . '"}'
);

$this->menu = [
    ['label' => Yii::t('StoreModule.store', 'Product') . ' «' . mb_substr($product->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Update product'),
        'url' => [
            '/store/productBackend/update',
            'id' => $product->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'View product'),
        'url' => [
            '/store/productBackend/view',
            'id' => $product->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-external-link-square',
        'label' => Yii::t('StoreModule.store', 'View product on site'),
        'url' => ProductHelper::getUrl($product),
        'linkOptions' => [
            'target' => '_blank',
        ],
        'visible' => $product->status == Product::STATUS_ACTIVE
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Delete product'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/store/productBackend/delete', 'id' => $product->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove product?'),
            'csrf' => true,
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-picture-o',
        'label' => Yii::t('StoreModule.store', 'Mass image upload'),
        'url' => [
            '/store/productImageBackend/index',
            'id' => $product->id
        ]
    ],
];

?>

<div class="page-header">
    <h1>
        <?= $this->pageTitle ?>
        <small>&laquo;<?= $product->getName() ?>&raquo;</small>
    </h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbTabs',
    [
        'type' => 'tabs',
        'tabs' => [
            [
                'id' => '_show',
                'label' => 'Загруженные изображения',
                'content' => $this->renderPartial(
                    '_show',
                    ['model' => $model, 'product' => $product],
                    true
                ),
                'active' => true,
            ],
            [
                'id' => '_add',
                'label' => 'Управление изображениями',
                'content' => $this->renderPartial('_add', ['model' => $model, 'product' => $product], true),
            ],
        ],
        'events' => ['shown' => 'js:loadContent']
    ]
);
