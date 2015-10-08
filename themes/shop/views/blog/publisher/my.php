<div class="page-header">
    <h1>
        <small><?= Yii::t('BlogModule.blog', 'My posts'); ?></small>
        <a class="btn btn-warning pull-right"
           href="<?= Yii::app()->createUrl('/blog/publisher/write'); ?>"><?= Yii::t(
                'BlogModule.blog',
                'Write post!'
            ); ?></a>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    [
        'id'           => 'my-post-grid',
        'type'         => 'condensed',
        'dataProvider' => $posts->search(),
        'columns'      => [
            [
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blog/view", "slug" => $data->blog->slug))',
                'filter' => CHtml::listData(Blog::model()->getList(), 'id', 'name')
            ],
            [
                'name'  => 'title',
                'value' => 'CHtml::link($data->title, $data->url)',
                'type'  => 'html'
            ],
            [
                'name' => 'publish_time',
            ],
            [
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => '$data->getStatus()',
                'filter' => Post::model()->getStatusList()
            ],
            [
                'header' => Yii::t('BlogModule.blog', 'Tags'),
                'value'  => 'implode(", ", $data->getTags())'
            ],
            [
                'header' => "<i class=\"glyphicon glyphicon-comment\"></i>",
                'value'  => 'CHtml::link(($data->commentsCount>0) ? $data->commentsCount-1 : 0,array("/comment/commentBackend/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'   => 'raw',
            ],
            [
                'class'           => 'bootstrap.widgets.TbButtonColumn',
                'template'        => '{delete}{update}',
                'deleteButtonUrl' => 'array("/blog/publisher/delete/", "id" => "$data->id")',
                'updateButtonUrl' => 'array("/blog/publisher/write/", "id" => "$data->id")',
                'buttons'         => [
                    'delete' => [
                        'visible' => '$data->status == Post::STATUS_DRAFT'
                    ],
                    'update' => [
                        'visible' => '$data->status == Post::STATUS_DRAFT'
                    ]
                ]
            ],
        ],
    ]
); ?>
