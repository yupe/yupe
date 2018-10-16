<?php
    $this->breadcrumbs = [
        Yii::t('StoreModule.store', 'Attributes') => ['/store/attributeBackend/index'],
        Yii::t('StoreModule.store', 'Edition'),
    ];

    $this->pageTitle = Yii::t('StoreModule.store', 'Attributes - editing');

    $this->menu = [
        [
            'icon' => 'fa fa-fw fa-list-alt',
            'label' => Yii::t('StoreModule.store', 'Manage attributes'),
            'url' => ['/store/attributeBackend/index'],
        ],
        [
            'icon' => 'fa fa-fw fa-plus-square',
            'label' => Yii::t('StoreModule.store', 'Create attribute'),
            'url' => ['/store/attributeBackend/create'],
        ],
        ['label' => Yii::t('StoreModule.store', 'Attribute').' «'.mb_substr($model->name, 0, 32).'»'],
        [
            'icon' => 'fa fa-fw fa-pencil',
            'label' => Yii::t('StoreModule.store', 'Update attribute'),
            'url' => [
                '/store/attributeBackend/update',
                'id' => $model->id,
            ],
        ],
        [
            'icon' => 'fa fa-fw fa-trash-o',
            'label' => Yii::t('StoreModule.store', 'Delete attribute'),
            'url' => '#',
            'linkOptions' => [
                'submit' => ['/store/attributeBackend/delete', 'id' => $model->id],
                'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove attribute?'),
                'csrf' => true,
            ],
        ],
    ];
?>
    <div class="page-header">
        <h1>
            <?= Yii::t('StoreModule.store', 'Updating attribute'); ?><br/>
            <small>&laquo;<?= $model->name; ?>&raquo;</small>
        </h1>
    </div>

<?= $this->renderPartial('_form', [
    'model' => $model,
    'types' => $types,
]); ?>