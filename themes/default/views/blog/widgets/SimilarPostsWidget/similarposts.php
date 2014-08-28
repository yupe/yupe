<?php Yii::import('application.modules.blog.BlogModule'); ?>

<?php if (count($posts)): ?>
    <div class=" alert alert-warning">
        <h4><?php echo Yii::t('BlogModule.blog', 'It will be interesting'); ?>:</h4>

        <div>
            <ul class="list-unstyled">
                <?php foreach ($posts as $post): ?>
                    <li><?php echo CHtml::link(
                            CHtml::encode($post->title),
                            array('/blog/post/show/', 'slug' => CHtml::encode($post->slug))
                        ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <?php $this->controller->widget(
            'blog.widgets.LastPostsOfBlogWidget',
            array('blogId' => $this->post->blog_id, 'postId' => $this->post->id, 'view' => 'in-post')
        ); ?>
    </div>
<?php endif; ?>
