<?php
$this->breadcrumbs = array(
    Yii::t('DictionaryModule.dictionary', 'Dictionaries')     => array('/dictionary/dictionaryBackend/index'),
    Yii::t('DictionaryModule.dictionary', 'Dictionary items') => array('/dictionary/dictionaryDataBackend/index'),
    $model->name                                              => array(
        '/dictionary/dictionaryDataBackend/view',
        'id' => $model->id
    ),
    Yii::t('DictionaryModule.dictionary', 'Edit'),
);

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - edit');

$this->menu = array(
    array(
        'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'),
                'url'   => array('/dictionary/dictionaryBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'),
                'url'   => array('/dictionary/dictionaryBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('DictionaryModule.dictionary', 'Items'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Items list'),
                'url'   => array('/dictionary/dictionaryDataBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Create item'),
                'url'   => array('/dictionary/dictionaryDataBackend/create')
            ),
            array(
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary item') . ' «' . mb_substr(
                        $model->name,
                        0,
                        32
                    ) . '»'
            ),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('DictionaryModule.dictionary', 'Edit dictionary item'),
                'url'   => array(
                    '/dictionary/dictionaryDataBackend/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('DictionaryModule.dictionary', 'Show dictionary item'),
                'url'   => array(
                    '/dictionary/dictionaryDataBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('DictionaryModule.dictionary', 'Remove dictionary item'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/dictionary/dictionaryDataBackend/delete', 'id' => $model->id),
                    'confirm' => Yii::t('DictionaryModule.dictionary', 'Do you really want do delete dictionary item?'),
                    'csrf'    => true,
                )
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Edit dictionary items'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
