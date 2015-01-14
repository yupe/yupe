<?php
$this->breadcrumbs = [
    Yii::t('CommentModule.comment', 'Comments') => ['/comment/commentBackend/index'],
    Yii::t('CommentModule.comment', 'Manage'),
];

$this->pageTitle = Yii::t('CommentModule.comment', 'Comments - management');

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
        <small><?php echo Yii::t('CommentModule.comment', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('CommentModule.comment', 'Find comments'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('comment-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'comment-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'  => 'model',
                'value' => '$data->getTargetTitleLink()',
                'type'  => 'html'
            ],
            'model_id',
            [
                'name'  => 'text',
                'value' => 'yupe\helpers\YText::characterLimiter($data->text, 150)',
                'type'  => 'html'
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/comment/commentBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Comment::STATUS_APPROVED   => ['class' => 'label-success'],
                    Comment::STATUS_DELETED    => ['class' => 'label-default'],
                    Comment::STATUS_NEED_CHECK => ['class' => 'label-warning'],
                    Comment::STATUS_SPAM       => ['class' => 'label-danger'],
                ],
            ],
            [
                'name'  => 'creation_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
            ],
            'name',
            'email',
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
