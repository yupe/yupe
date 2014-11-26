<?php
$this->breadcrumbs = [
    Yii::t('DictionaryModule.dictionary', 'Dictionaries')     => ['/dictionary/dictionaryBackend/index'],
    Yii::t('DictionaryModule.dictionary', 'Dictionary items') => ['/dictionary/dictionaryDataBackend/index'],
    Yii::t('DictionaryModule.dictionary', 'Create'),
];

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - create');

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
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionary items'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
