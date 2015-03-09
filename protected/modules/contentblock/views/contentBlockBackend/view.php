<?php
$this->breadcrumbs = [
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => ['/contentblock/contentBlockBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - view');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'),
        'url'   => ['/contentblock/contentBlockBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Add new content block'),
        'url'   => ['/contentblock/contentBlockBackend/create']
    ],
    [
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks') . ' «' . mb_substr(
                $model->name,
                0,
                32
            ) . '»'
    ],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('ContentBlockModule.contentblock', 'Edit content block'),
        'url'   => [
            '/contentblock/contentBlockBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('ContentBlockModule.contentblock', 'View content block'),
        'url'   => [
            '/contentblock/contentBlockBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('ContentBlockModule.contentblock', 'Remove content block'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/contentblock/contentBlockBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('ContentBlockModule.contentblock', 'Do you really want to delete content block?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Viewing content block'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            [
                'name'  => 'category_id',
                'value' => $model->getCategoryName()
            ],
            [
                'name'  => 'type',
                'value' => $model->getType(),
            ],
            'content',
            [
                'name' => 'description',
                'type' => 'raw',
                'value' => $model->description,
            ]
        ],
    ]
); ?>

<br/>
<div>
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Shortcode for using this block in template:'); ?>
    <br/><br/>
    <?php echo $example; ?>
</div>
<div>
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Shortcode for using this block group in template:'); ?>
    <br /><br />
    <?php echo $exampleCategory; ?>
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Parameter Description:<br><ul><li>category - category code. Required paramert;</li><li>limit - how much of the output. Not obligatory paramert;</li><li>cacheTime - cache lifetime (as is frequently updated cache). Not obligatory paramert;</li><li>rand - determines how to display units, randomly or not. "true" or "false" (default "false").</li></ul>'); ?>
</div>