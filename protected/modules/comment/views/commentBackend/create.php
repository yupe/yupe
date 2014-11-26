<?php
$this->breadcrumbs = [
    Yii::t('CommentModule.comment', 'Comments') => ['/comment/commentBackend/index'],
    Yii::t('CommentModule.comment', 'Create'),
];

$this->pageTitle = Yii::t('CommentModule.comment', 'Comment - create');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CommentModule.comment', 'Comments list'),
        'url'   => ['/comment/commentBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CommentModule.comment', 'Create comment'),
        'url'   => ['/comment/commentBackend/create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Comments'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
