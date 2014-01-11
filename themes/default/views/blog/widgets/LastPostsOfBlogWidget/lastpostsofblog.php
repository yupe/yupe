<?php Yii::import('application.modules.blog.BlogModule'); ?>

<div class="posts">

    <p class="posts-header">
        <span class="posts-header-text"><?php echo Yii::t('BlogModule.blog','Last blog posts'); ?></span>
    </p>

    <div class="posts-list">
        <?php foreach($posts as $post):?>
            <div class="posts-list-block">
                <div class="posts-list-block-header">
                    <?php echo CHtml::link(
                        CHtml::encode($post->title), array(
                            '/blog/post/show/',
                            'slug' => $post->slug
                        )
                    ); ?>
                </div>

                <div class="posts-list-block-meta">
                    <span>
                        <i class="icon-user"></i>
                        
                        <?php $this->widget(
                            'application.modules.user.widgets.UserPopupInfoWidget', array(
                                'model' => $post->createUser
                            )
                        ); ?>
                    </span>

                    <span>
                        <i class="icon-pencil"></i>

                        <?php echo CHtml::link(
                            $post->blog->name, array(
                                '/blog/blog/show/',
                                'slug' => $post->blog->slug
                            )
                        ); ?>
                    </span>

                    <span>
                        <i class="icon-calendar"></i>

                        <?php echo Yii::app()->getDateFormatter()->formatDateTime(
                            $post->publish_date, "long", "short"
                        ); ?>
                    </span>
                </div>

                <div class="posts-list-block-text">
                    <?php echo strip_tags($post->getQuote()); ?>
                </div>

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
            </div>
        <?php endforeach; ?>
    </div>
</div>