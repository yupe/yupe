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
        'actionsButtons' => [
            'approve' => CHtml::link(Yii::t('CommentModule.comment', 'Approve'), '#', [
                    'id' => 'approve-comments',
                    'class' => 'btn btn-sm btn-info pull-right disabled bulk-actions-btn',
                    'style' => 'margin-left: 4px;'
                ]
            ),
            'add' => CHtml::link(
                Yii::t('CommentModule.comment', 'Add'),
                ['/comment/commentBackend/create'],
                ['class' => 'btn btn-sm btn-success pull-right']
            ),
        ],
        'columns'      => [
            [
                'name'  => 'model',
                'value' => '$data->getTargetTitleLink()',
                'type'  => 'html'
            ],
            'model_id',
            [
                'name'  => 'text',
                'value' => 'yupe\helpers\YText::characterLimiter($data->getText(), 150)',
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
                'name'  => 'create_time',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
            ],
            'name',
            'email',
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
);

$url = Yii::app()->createUrl('/comment/commentBackend/approve');
$tokenName = Yii::app()->getRequest()->csrfTokenName;
$token = Yii::app()->getRequest()->csrfToken;
$confirmMessage = Yii::t('CommentModule.comment', 'Do you really want to approve selected elements?');
$noCheckedMessage = Yii::t('CommentModule.comment', 'No items are checked');
$errorMessage = Yii::t('CommentModule.comment', 'Error!');

Yii::app()->getClientScript()->registerScript(
    __FILE__,
    <<<JS
    $('body').on('click', '#approve-comments', function (e) {
        e.preventDefault();
        var checked = $.fn.yiiGridView.getCheckedRowsIds('comment-grid');
        if (!checked.length) {
            alert("$noCheckedMessage");
            return false;
        }
        var url = "$url";
        var data = {};
        data['$tokenName'] = "$token";
        data['items'] = checked;
        if(confirm("$confirmMessage")){
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.result) {
                        $.fn.yiiGridView.update("comment-grid");
                    } else {
                        alert(data.data);
                    }
                },
                error: function (data) {alert("$errorMessage")}
            });
        }
    });
JS
, CClientScript::POS_READY
);

