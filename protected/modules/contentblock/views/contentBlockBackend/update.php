<?php
$this->breadcrumbs = [
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => ['/contentblock/contentBlockBackend/index'],
    $model->name                                                => [
        '/contentblock/contentBlockBackend/view',
        'id' => $model->id
    ],
    Yii::t('ContentBlockModule.contentblock', 'Editing'),
];

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - edit');

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
    [
        'label' => Yii::t('ContentBlockModule.contentblock', 'Content block') . ' «' . mb_substr(
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
            'confirm' => Yii::t('ContentBlockModule.contentblock', 'Do you really want to remove content block?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Editing blocks'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
