<?php
$this->pageTitle = Yii::t('BlogModule.blog', 'Latest posts');
$this->description = Yii::t('BlogModule.blog', 'Latest post');
$this->keywords = Yii::t('BlogModule.blog', 'Latest post');
?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'Latest posts'),
); ?>

<div class="posts">

    <h1>
        <small>
            <?php echo Yii::t('BlogModule.blog', 'Latest posts'); ?> <a
                href="<?php echo Yii::app()->createUrl('/blog/blogRss/feed/'); ?>">
                <img src="<?php echo Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png"; ?>"
                     alt="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"
                     title="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"></a>
        </small>
        <?php if (Yii::app()->getUser()->isAuthenticated()): ?>
            <a class="btn btn-warning pull-right"
               href="<?php echo Yii::app()->createUrl('/blog/publisher/write'); ?>"><?php echo Yii::t(
                    'BlogModule.blog',
                    'Write post!'
                ); ?></a>
        <?php else: ?>
            <a class="btn btn-warning pull-right"
               href="<?php echo Yii::app()->createUrl('/user/account/login'); ?>"><?php echo Yii::t(
                    'BlogModule.blog',
                    'Write post!'
                ); ?></a>
        <?php endif; ?>
    </h1>

    <br/>

    <?php $this->widget(
        'bootstrap.widgets.TbListView',
        array(
            'id'           => 'posts-list',
            'dataProvider' => $model->allPosts(),
            'itemView'     => '_post',
            'template'     => "{items}\n{pager}",
            'ajaxUpdate'   => false,
            'htmlOptions'  => array(
                'class' => 'posts-list'
            )
        )
    ); ?>
</div>
