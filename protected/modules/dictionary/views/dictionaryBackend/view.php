<?php
$this->breadcrumbs = array(
    Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/dictionaryBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - show');

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
            array(
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary') . ' «' . mb_substr(
                        $model->name,
                        0,
                        32
                    ) . '»'
            ),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('DictionaryModule.dictionary', 'Edit dictionary'),
                'url'   => array(
                    '/dictionary/dictionaryBackend/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('DictionaryModule.dictionary', 'Show dictionary'),
                'url'   => array(
                    '/dictionary/dictionaryBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('DictionaryModule.dictionary', 'Remove dictionary'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/dictionary/dictionaryBackend/delete', 'id' => $model->id),
                    'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                    'confirm' => Yii::t('DictionaryModule.dictionary', 'Do you really want do delete dictionary?'),
                )
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
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Show dictionary'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'code',
            'name',
            array(
                'name' => 'description',
                'type' => 'raw'
            ),
            array(
                'name'  => 'creation_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"),
            ),
            array(
                'name'  => 'update_date',
                'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
            ),
            array(
                'name'  => 'create_user_id',
                'value' => $model->createUser->getFullName(),
            ),
            array(
                'name'  => 'update_user_id',
                'value' => $model->updateUser->getFullName(),
            ),
        ),
    )
); ?>
