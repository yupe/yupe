<?php if ($user->isAuthenticated()): ?>
    <?php if (false === $inBlog || UserToBlog::STATUS_DELETED === $inBlog): ?>
        <a class="btn btn-warning pull-right join-blog" href="<?php echo $blog->id; ?>" data-url="<?php echo Yii::app()->createUrl('/blog/blog/join');?>"><?php echo Yii::t(
                'BlogModule.blog',
                'Join blog'
            ); ?></a>
    <?php elseif($inBlog == UserToBlog::STATUS_CONFIRMATION):?>
        <p class="pull-right"><?php echo Yii::t('BlogModule.blog', 'Wait for confirmation');?></p>
    <?php else: ?>
        <a class="btn btn-warning pull-right leave-blog" href="<?php echo $blog->id; ?>" data-url="<?php echo Yii::app()->createUrl('/blog/blog/leave');?>"><?php echo Yii::t(
                'BlogModule.blog',
                'Leave blog'
            ); ?></a>
    <?php endif; ?>
<?php else: ?>
    <a class="btn btn-warning pull-right"
       href="<?php echo Yii::app()->createUrl('/user/account/login'); ?>"><?php echo Yii::t(
            'BlogModule.blog',
            'Join blog'
        ); ?></a>
<?php endif; ?>