<?php
$this->breadcrumbs = [
    Yii::t('PageModule.page', 'Pages') => ['/page/pageBackend/index'],
    $model->title,
];

$this->pageTitle = Yii::t('PageModule.page', 'Show page');

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
    ['label' => Yii::t('PageModule.page', 'Page') . ' «' . mb_substr($model->title, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('PageModule.page', 'Edit page'),
        'url'   => [
            '/page/pageBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('PageModule.page', 'Show page'),
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
        ]
    ],
];
?>

<div class="page-header">
    <h1>
        <?= Yii::t('PageModule.page', 'Show page'); ?>
        <small>&laquo;<?= $model->title; ?>&raquo;</small>
    </h1>
</div>

<h2><?= $model->title; ?></h2>

<small><?= Yii::t('PageModule.page', 'Author'); ?>
    : <?= ($model->changeAuthor instanceof User) ? $model->changeAuthor->getFullName() : Yii::t(
        'PageModule.page',
        'Removed'
    ); ?></small>
<br/>
<br/>

<p><?= $model->body; ?></p>
<br/>

<li class="fa fa-fw fa-globe"></li>
<?= CHtml::link(Yii::app()->createAbsoluteUrl('/page/page/view', ['slug' => $model->slug]), Yii::app()->createAbsoluteUrl('/page/page/view', ['slug' => $model->slug])); ?>
