<?php
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/newsBackend/index'],
    Yii::t('NewsModule.news', 'Create'),
];

$this->pageTitle = Yii::t('NewsModule.news', 'News - create');

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
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'News'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'languages' => $languages]); ?>
