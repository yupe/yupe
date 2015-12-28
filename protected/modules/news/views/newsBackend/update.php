<?php
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/newsBackend/index'],
    $model->title => ['/news/newsBackend/view', 'id' => $model->id],
    Yii::t('NewsModule.news', 'Edit'),
];

$this->pageTitle = Yii::t('NewsModule.news', 'News - edit');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('NewsModule.news', 'News management'),
        'url' => ['/news/newsBackend/index'],
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('NewsModule.news', 'Create news'),
        'url' => ['/news/newsBackend/create'],
    ],
    ['label' => Yii::t('NewsModule.news', 'News Article') . ' «' . mb_substr($model->title, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('NewsModule.news', 'Edit news'),
        'url' => [
            '/news/newsBackend/update/',
            'id' => $model->id,
        ],
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('NewsModule.news', 'View news article'),
        'url' => [
            '/news/newsBackend/view',
            'id' => $model->id,
        ],
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('NewsModule.news', 'Removing news'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/news/newsBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('NewsModule.news', 'Do you really want to remove the article?'),
            'csrf' => true,
        ],
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Edit news article'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial(
    '_form',
    ['model' => $model, 'languages' => $languages, 'langModels' => $langModels]
); ?>
