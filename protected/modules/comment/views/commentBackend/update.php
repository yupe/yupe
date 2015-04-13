<?php
$this->breadcrumbs = [
    Yii::t('CommentModule.comment', 'Comments') => ['/comment/commentBackend/index'],
    $model->id                                  => ['/comment/commentBackend/view', 'id' => $model->id],
    Yii::t('CommentModule.comment', 'Edit'),
];

$this->pageTitle = Yii::t('CommentModule.comment', 'Comments - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CommentModule.comment', 'Manage comments'),
        'url'   => ['/comment/commentBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CommentModule.comment', 'Create comment'),
        'url'   => ['/comment/commentBackend/create']
    ],
    ['label' => Yii::t('CommentModule.comment', 'Comment') . ' «' . mb_substr($model->id, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CommentModule.comment', 'Edit comment'),
        'url'   => [
            '/comment/commentBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('CommentModule.comment', 'View comment'),
        'url'   => [
            '/comment/commentBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('CommentModule.comment', 'Delete comment'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/comment/commentBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('CommentModule.comment', 'Do you really want do remove comment?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Editing comment'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
