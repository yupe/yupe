<?php
$this->breadcrumbs = [
    Yii::t('CategoryModule.category', 'Categories') => ['/category/categoryBackend/index'],
    Yii::t('CategoryModule.category', 'Create'),
];

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - create');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => ['/category/categoryBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => ['/category/categoryBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Category'); ?>
        <small><?php echo Yii::t('CategoryModule.category', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model, 'languages' => $languages]); ?>
