<?php Yii::import('application.modules.blog.BlogModule'); ?>
<?php if(count($posts)):?>
    <div class="alert alert-notice">
        <h4><?php echo Yii::t('BlogModule.blog', 'read also:');?></h4>
        <ul>
            <?php foreach ($posts as $post):?>
                <li><?php echo CHtml::link($post->title, array('/blog/post/show/','slug' => $post->slug));?></li>
            <?php endforeach;?>
        </ul>
    </div>
<?php else:?>
    <div class="alert alert-notice">
        <?php $this->controller->widget('blog.widgets.LastPostsOfBlogWidget', array('blogId' => $this->post->blog_id, 'view' => 'in-post')); ?>
    </div>
<?php endif;?>