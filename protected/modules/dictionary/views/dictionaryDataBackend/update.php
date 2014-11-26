<?php
$this->breadcrumbs = [
    Yii::t('DictionaryModule.dictionary', 'Dictionaries')     => ['/dictionary/dictionaryBackend/index'],
    Yii::t('DictionaryModule.dictionary', 'Dictionary items') => ['/dictionary/dictionaryDataBackend/index'],
    $model->name                                              => [
        '/dictionary/dictionaryDataBackend/view',
        'id' => $model->id
    ],
    Yii::t('DictionaryModule.dictionary', 'Edit'),
];

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - edit');

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
        <?php echo Yii::t('DictionaryModule.dictionary', 'Edit dictionary items'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
