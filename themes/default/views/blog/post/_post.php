<div class="posts-list-block">
    <div class="posts-list-block-header">
        <?php echo CHtml::link(
            CHtml::encode($data->title),
            array('/blog/post/show/', 'slug' => CHtml::encode($data->slug))
        ); ?>
    </div>

    <div class="posts-list-block-meta">
	        <span>
	            <i class="glyphicon glyphicon-user"></i>
                <?php $this->widget(
                    'application.modules.user.widgets.UserPopupInfoWidget',
                    array(
                        'model' => $data->createUser
                    )
                ); ?>
	        </span>

	        <span>
	            <i class="glyphicon glyphicon-pencil"></i>

                <?php echo CHtml::link(
                    CHtml::encode($data->blog->name),
                    array(
                        '/blog/blog/show/',
                        'slug' => CHtml::encode($data->blog->slug)
                    )
                ); ?>
	        </span>

	        <span>
	            <i class="glyphicon glyphicon-calendar"></i>

                <?php echo Yii::app()->getDateFormatter()->formatDateTime(
                    $data->publish_date,
                    "long",
                    "short"
                ); ?>
	        </span>
    </div>

    <div class="posts-list-block-text">
        <p>
            <?php echo $data->getImageUrl() ? CHtml::image($data->getImageUrl(), CHtml::encode($data->title)) : "";?>
        </p>
        <?php echo strip_tags($data->getQuote()); ?>
    </div>

    <div class="posts-list-block-tags">
        <div>
	        <span class="posts-list-block-tags-block">
	            <i class="glyphicon glyphicon-tags"></i>

                <?php echo Yii::t('BlogModule.blog', 'Tags'); ?>:

                <?php foreach ((array)$data->getTags() as $tag): ?>
                    <span>
	                    <?php echo CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag))); ?>
	                </span>
                <?php endforeach; ?>
	        </span>

	        <span class="posts-list-block-tags-comments">
	            <i class="glyphicon glyphicon-comment"></i>

                <?php echo CHtml::link(
                    $data->getCommentCount(),
                    array(
                        '/blog/post/show/',
                        'slug' => CHtml::encode($data->slug),
                        '#'    => 'comments'
                    )
                );?>
	        </span>
        </div>
    </div>
</div>
