<div class="row">
    <div class="span8">
        <p></p>
        <p>
            <?php echo CHtml::image($post->createUser->getAvatar(16));?> <?php echo CHtml::link($post->createUser->nick_name, array('/user/people/userInfo', 'username' => $post->createUser->nick_name)); ?>
            | <i class="icon-pencil"></i> <?php echo CHtml::link($post->blog->name, array('/blog/blog/show/', 'slug' => $post->blog->slug)); ?>
            | <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "long", "short"); ?>
            | <i class="icon-comment"></i>  <?php echo CHtml::link(($post->commentsCount>0)? $post->commentsCount-1 : 0 , array('/blog/post/show/', 'slug' => $post->slug, '#' => 'comments'));?>
            | <i class="icon-tags"></i>
            <?php if (($tags = $post->getTags()) != array()):?>
                <?php foreach ($tags as $tag):?>
                    <span class="label label-info">
                        <?php echo CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag)));?>
                    </span>
                <?php endforeach?>
            <?php endif;?>
        </p>
    </div>
</div>