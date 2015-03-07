<?php
$this->breadcrumbs = [
    Yii::t('DictionaryModule.dictionary', 'Dictionaries') => ['/dictionary/dictionaryBackend/index'],
    $model->name                                          => [
        '/dictionary/dictionaryBackend/view',
        'id' => $model->id
    ],
    Yii::t('DictionaryModule.dictionary', 'Edit'),
];

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - edit');

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
            [
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary') . ' «' . mb_substr(
                        $model->name,
                        0,
                        32
                    ) . '»'
            ],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('DictionaryModule.dictionary', 'Edit dictionary'),
                'url'   => [
                    '/dictionary/dictionaryBackend/update',
                    'id' => $model->id
                ]
            ],
            [
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('DictionaryModule.dictionary', 'Show dictionary'),
                'url'   => [
                    '/dictionary/dictionaryBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('DictionaryModule.dictionary', 'Remove dictionary'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/dictionary/dictionaryBackend/delete', 'id' => $model->id],
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                    'confirm' => Yii::t('DictionaryModule.dictionary', 'Do you really want do delete dictionary?'),
                ]
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
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Update dictionary'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
