<?php
$this->pageTitle = CHtml::encode($blog->name);
$this->description = CHtml::encode($blog->name);
$this->keywords = CHtml::encode($blog->name);
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($blog->name),
];
?>
<div class="row">
    <div class="col-sm-12">
        <div class="blog-logo pull-left">
            <?php echo CHtml::image(
                $blog->getImageUrl(),
                CHtml::encode($blog->name),
                [
                    'width'  => 109,
                    'height' => 109
                ]
            ); ?>
        </div>
        <div class="blog-description">
            <div class="blog-description-name">

                <?php echo CHtml::link(
                    CHtml::encode($blog->name),
                    ['/blog/post/blog/', 'slug' => CHtml::encode($blog->slug)]
                ); ?>

                <?php echo CHtml::link(
                    CHtml::image(
                        Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png",
                        Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . CHtml::encode($blog->name),
                        [
                            'title' => Yii::t('BlogModule.blog', 'Subscribe for updates') . ' ' . CHtml::encode(
                                    $blog->name
                                ),
                            'class' => 'rss'
                        ]
                    ),
                    [
                        '/blog/blogRss/feed/',
                        'blog' => $blog->id
                    ]
                ); ?>

                <div class="pull-right">
                    <?php $this->widget(
                        'application.modules.blog.widgets.JoinBlogWidget',
                        ['user' => Yii::app()->user, 'blog' => $blog]
                    ); ?>
                    <?php
                    if ($blog->userIn(Yii::app()->user->getId())) {
                        echo CHtml::link(Yii::t('BlogModule.blog', 'Add a post'), ['/blog/publisher/write', 'blog-id' => $blog->id], ['class' => 'btn btn-success btn-sm']);
                    }
                    ?>
                </div>


            </div>

            <div class="blog-description-info">

            <span class="blog-description-owner">
                <i class="glyphicon glyphicon-user"></i>
                <?php echo Yii::t('BlogModule.blog', 'Created'); ?>:
                <strong>
                    <?php $this->widget(
                        'application.modules.user.widgets.UserPopupInfoWidget',
                        [
                            'model' => $blog->createUser
                        ]
                    ); ?>
                </strong>
            </span>

            <span class="blog-description-datetime">
                <i class="glyphicon glyphicon-calendar"></i>
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?>
            </span>

            <span class="blog-description-posts">
                <i class="glyphicon glyphicon-pencil"></i>
                <?php echo CHtml::link(
                    count($blog->posts),
                    ['/blog/post/blog/', 'slug' => CHtml::encode($blog->slug)]
                ); ?>
            </span>

            </div>

            <?php if ($blog->description) : ?>
                <div class="blog-description-text">
                    <?php echo strip_tags($blog->description); ?>
                </div>
            <?php endif; ?>

            <?php $this->widget('blog.widgets.MembersOfBlogWidget', ['blogId' => $blog->id, 'blog' => $blog]); ?>

        </div>
    </div>
</div>

<?php $this->widget('blog.widgets.LastPostsOfBlogWidget', ['blogId' => $blog->id, 'limit' => 10]); ?>

<br/>

<?php echo CHtml::link(
    Yii::t('BlogModule.blog', 'All entries for blog "{blog}"', ['{blog}' => CHtml::encode($blog->name)]),
    ['/blog/post/blog/', 'slug' => $blog->slug],
    ['class' => 'btn btn-default']
); ?>

<br/><br/>

<?php $this->widget('application.modules.blog.widgets.ShareWidget'); ?>
