<?php
    $this->pageTitle   = CHtml::encode($blog->name);
    $this->description = CHtml::encode($blog->name);
    $this->keywords    = CHtml::encode($blog->name);
?>

<?php
    $this->breadcrumbs = array(
        Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
        CHtml::encode($blog->name),
    );
?>
<div class="row-fluid">
    <div class="blog-logo pull-left">
        <?php echo CHtml::image(
            $blog->getImageUrl(), CHtml::encode($blog->name),
            array(
                'width'  => 109,
                'height' => 109
            )
        ); ?>
    </div>
    <div class="blog-description">
        <div class="blog-description-name">

            <?php echo CHtml::link(CHtml::encode($blog->name), array('/blog/post/blog/','slug' => CHtml::encode($blog->slug))); ?>
            
            <?php echo CHtml::link(
                CHtml::image(
                    Yii::app()->baseUrl . "/web/images/rss.png",
                    Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . CHtml::encode($blog->name),
                    array(
                        'title' => Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . CHtml::encode($blog->name),
                        'class' => 'rss'
                    )
                ), array(
                    '/blog/blogRss/feed/', 'blog' => $blog->id                    
                )
            ); ?>

            <?php $this->widget('application.modules.blog.widgets.JoinBlogWidget', array('user' => Yii::app()->user, 'blog' => $blog));?>

        </div>

        <div class="blog-description-info">

            <span class="blog-description-owner">
                <i class="icon-user"></i>
                <?php echo Yii::t('BlogModule.blog', 'Created'); ?>:
                <strong>
                    <?php $this->widget(
                        'application.modules.user.widgets.UserPopupInfoWidget', array(
                            'model' => $blog->createUser
                        )
                    ); ?>
                </strong>
            </span>

            <span class="blog-description-datetime">
                <i class="icon-calendar"></i>
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?>
            </span>

            <span class="blog-description-posts">
                <i class="icon-pencil"></i>
                <?php echo CHtml::link(count($blog->posts), array('/blog/post/blog/','slug' => CHtml::encode($blog->slug))); ?>
            </span>       

        </div>

        <?php if ($blog->description) : ?>
        <div class="blog-description-text">
            <?php echo strip_tags($blog->description); ?>
        </div>
        <?php endif; ?>
        
        <?php $this->widget('blog.widgets.MembersOfBlogWidget', array('blogId' => $blog->id, 'blog' => $blog)); ?>

    </div>

</div>

<?php $this->widget('blog.widgets.LastPostsOfBlogWidget', array('blogId' => $blog->id, 'limit' => 10)); ?>

<br/>

<?php echo CHtml::link(Yii::t('BlogModule.blog', 'All entries for blog "{blog}"', array('{blog}' => CHtml::encode($blog->name))), array('/blog/post/blog/','slug' => $blog->slug), array('class' => 'btn'));?>

<br/><br/>

<?php $this->widget('application.modules.blog.widgets.ShareWidget');?>

