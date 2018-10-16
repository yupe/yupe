<?php
$this->breadcrumbs = [
    Yii::t('DictionaryModule.dictionary', 'Dictionaries') => ['/dictionary/dictionaryBackend/index'],
    Yii::t('DictionaryModule.dictionary', 'Management'),
];

$this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - manage');

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
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionaries'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Find dictionary'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('dictionary-group-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'dictionary-group-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/dictionary/dictionaryBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'      => [
            [
                'name'        => 'id',
                'htmlOptions' => ['style' => 'width:20px'],
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/dictionary/dictionaryBackend/update", "id" => $data->id))'
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'description',
                'editable' => [
                    'url'    => $this->createUrl('/dictionary/dictionaryBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'description', ['class' => 'form-control']),
            ],
            [
                'header' => Yii::t('DictionaryModule.dictionary', 'Records'),
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->dataCount, array("/dictionary/dictionaryDataBackend/index", "group_id" => $data->id))',
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
