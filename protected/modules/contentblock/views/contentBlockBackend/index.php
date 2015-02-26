<?php
/**
 * @var $this ContentBlockBackendController
 * @var $model ContentBlock
 */
$this->breadcrumbs = [
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => ['/contentblock/contentBlockBackend/index'],
    Yii::t('ContentBlockModule.contentblock', 'Administration'),
];

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - admin');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'),
        'url'   => ['/contentblock/contentBlockBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Add content block'),
        'url'   => ['/contentblock/contentBlockBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Blocks'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'administration'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Find content blocks'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('content-block-grid', {
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
        'id'           => 'content-block-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'type'   => 'select',
                    'title'  => Yii::t(
                        'ContentBlockModule.contentblock',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('type'))]
                    ),
                    'source' => $model->getTypes(),
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'name'     => 'type',
                'type'     => 'raw',
                'value'    => '$data->getType()',
                'filter'   => CHtml::activeDropDownList(
                    $model,
                    'type',
                    $model->getTypes(),
                    ['class' => 'form-control', 'empty' => '']
                ),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/contentblock/contentBlockBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'name'  => 'description',
                'type'  => 'raw',
                'value' => '$data->description',
            ],
            [
                'class'                => '\yupe\widgets\ToggleColumn',
                'name'                 => 'status',
                'checkedButtonLabel'   => Yii::t('ContentBlockModule.contentblock', 'Turn off'),
                'uncheckedButtonLabel' => Yii::t('ContentBlockModule.contentblock', 'Turn on'),
                'filter'               => $model->getStatusList(),
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
