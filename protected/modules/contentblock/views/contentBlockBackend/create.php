<?php
$this->breadcrumbs = [
    Yii::t('ContentBlockModule.contentblock', 'Content blocks') => ['/contentblock/contentBlockBackend/index'],
    Yii::t('ContentBlockModule.contentblock', 'Create'),
];

$this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - add');

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
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Content block'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'add'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
