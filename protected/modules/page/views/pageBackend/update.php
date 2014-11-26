<?php
$this->breadcrumbs = [
    Yii::t('PageModule.page', 'Pages') => ['/page/pageBackend/index'],
    $model->title                      => ['/page/pageBackend/view', 'id' => $model->id],
    Yii::t('PageModule.page', 'Edit'),
];

$this->pageTitle = Yii::t('PageModule.page', 'Pages - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('PageModule.page', 'Pages list'),
        'url'   => ['/page/pageBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('PageModule.page', 'Create page'),
        'url'   => ['/page/pageBackend/create']
    ],
    ['label' => Yii::t('PageModule.page', 'Article') . ' «' . mb_substr($model->title, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('PageModule.page', 'Edit page'),
        'url'   => [
            '/page/pageBackend/update/',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('PageModule.page', 'View page'),
        'url'   => [
            '/page/pageBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('PageModule.page', 'Remove page'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/page/pageBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('PageModule.page', 'Do you really want to remove page?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Edit page'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial(
    '_form',
    [
        'menuId'       => $menuId,
        'menuParentId' => $menuParentId,
        'pages'        => $pages,
        'model'        => $model,
        'languages'    => $languages,
        'langModels'   => $langModels
    ]
); ?>
