<div class="posts-list-block-tags">
    <div>
        <span class="posts-list-block-tags-block">
            <i class="icon-tags"></i>
            
            <?php echo Yii::t('BlogModule.blog','Tags'); ?>:

            <?php foreach ((array) $post->getTags() as $tag):?>
                <span>
                    <?php echo CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag)));?>
                </span>
            <?php endforeach;?>
        </span>

        <span>
            <i class="icon-user"></i>            
            <?php $this->widget(
                'application.modules.user.widgets.UserPopupInfoWidget', array(
                    'model' => $post->createUser
                )
            ); ?>
        </span>

        <span class="posts-list-block-tags-comments">
            <i class="icon-comments"></i>

            <?php echo CHtml::link(
                $post->getCommentCount(),
                array(
                    '/blog/post/show/',
                    'slug' => $post->slug,
                    '#' => 'comments'
                )
            );?>
        </span>
    </div>
</div>