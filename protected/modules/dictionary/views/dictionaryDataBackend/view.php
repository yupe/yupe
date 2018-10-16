<?php
$this->breadcrumbs = [
    Yii::t('DictionaryModule.dictionary', 'Dictionaries')     => ['/dictionary/dictionaryBackend/index'],
    Yii::t('DictionaryModule.dictionary', 'Dictionary items') => ['/dictionary/dictionaryDataBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - show');

$this->menu = [
    [
        'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'),
                'url'   => ['/dictionary/dictionaryBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'),
                'url'   => ['/dictionary/dictionaryBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('DictionaryModule.dictionary', 'Items'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Items list'),
                'url'   => ['/dictionary/dictionaryDataBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Create item'),
                'url'   => ['/dictionary/dictionaryDataBackend/create']
            ],
            [
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary item') . ' «' . mb_substr(
                        $model->name,
                        0,
                        32
                    ) . '»'
            ],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('DictionaryModule.dictionary', 'Edit dictionary item'),
                'url'   => [
                    '/dictionary/dictionaryDataBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('DictionaryModule.dictionary', 'Show dictionary item'),
                'url'   => [
                    '/dictionary/dictionaryDataBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('DictionaryModule.dictionary', 'Remove dictionary item'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/dictionary/dictionaryDataBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('DictionaryModule.dictionary', 'Do you really want do delete dictionary item?'),
                    'csrf'    => true,
                ]
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?=  Yii::t('DictionaryModule.dictionary', 'Show dictionary items'); ?><br/>
        <small>&laquo;<?=  $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            [
                'name'  => 'group_id',
                'value' => $model->group->name,
            ],
            'code',
            'name',
            'value',
            [
                'name' => 'description',
                'type' => 'raw'
            ],
            [
                'name'  => 'create_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
            ],
            [
                'name'  => 'update_time',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
            ],
            [
                'name'  => 'create_user_id',
                'value' => $model->createUser->getFullName(),
            ],
            [
                'name'  => 'update_user_id',
                'value' => $model->updateUser->getFullName(),
            ],
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
        ],
    ]
); ?>
