<div class="page-header">
    <h1>
        <small><?php echo Yii::t('BlogModule.blog', 'My posts'); ?></small>
        <a class="btn btn-warning pull-right"
           href="<?php echo Yii::app()->createUrl('/blog/publisher/write'); ?>"><?php echo Yii::t(
                'BlogModule.blog',
                'Write post!'
            ); ?></a>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'id'           => 'my-post-grid',
        'type'         => 'condensed',
        'dataProvider' => $posts->search(),
        'columns'      => array(
            array(
                'name'   => 'blog_id',
                'type'   => 'raw',
                'value'  => 'CHtml::link($data->blog->name, array("/blog/blog/show", "slug" => $data->blog->slug))',
                'filter' => CHtml::listData(Blog::model()->getList(), 'id', 'name')
            ),
            array(
                'name'  => 'title',
                'value' => 'CHtml::link($data->title, array("/blog/post/show", "slug" => $data->slug))',
                'type'  => 'html'
            ),
            array(
                'name' => 'publish_date',
            ),
            array(
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => '$data->getStatus()',
                'filter' => Post::model()->getStatusList()
            ),
            array(
                'header' => Yii::t('BlogModule.blog', 'Tags'),
                'value'  => 'implode(", ", $data->getTags())'
            ),
            array(
                'header' => "<i class=\"glyphicon glyphicon-comment\"></i>",
                'value'  => 'CHtml::link(($data->commentsCount>0) ? $data->commentsCount-1 : 0,array("/comment/commentBackend/index/","Comment[model]" => "Post","Comment[model_id]" => $data->id))',
                'type'   => 'raw',
            ),
            array(
                'class'           => 'bootstrap.widgets.TbButtonColumn',
                'template'        => '{delete}{update}',
                'deleteButtonUrl' => 'array("/blog/publisher/delete/", "id" => "$data->id")',
                'updateButtonUrl' => 'array("/blog/publisher/write/", "id" => "$data->id")',
                'buttons'         => array(
                    'delete' => array(
                        'visible' => '$data->status == Post::STATUS_DRAFT'
                    ),
                    'update' => array(
                        'visible' => '$data->status == Post::STATUS_DRAFT'
                    )
                )
            ),
        ),
    )
); ?>
