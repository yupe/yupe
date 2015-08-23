<?php
/**
 * @var $this PostController
 */
$this->title = [Yii::t('BlogModule.blog', 'Latest posts'), Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = Yii::t('BlogModule.blog', 'Latest post');
$this->metaKeywords = Yii::t('BlogModule.blog', 'Latest post');
?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Latest posts'),
]; ?>

<div class="posts">

    <h1>
        <small>
            <?= Yii::t('BlogModule.blog', 'Latest posts'); ?> <a
                href="<?= Yii::app()->createUrl('/blog/blogRss/feed/'); ?>">
                <img src="<?= Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png"; ?>"
                     alt="<?= Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"
                     title="<?= Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"></a>
        </small>
        <?php if (Yii::app()->getUser()->isAuthenticated()): ?>
            <a class="btn btn-warning pull-right"
               href="<?= Yii::app()->createUrl('/blog/publisher/write'); ?>"><?= Yii::t(
                    'BlogModule.blog',
                    'Write post!'
                ); ?></a>
        <?php else: ?>
            <a class="btn btn-warning pull-right"
               href="<?= Yii::app()->createUrl('/user/account/login'); ?>"><?= Yii::t(
                    'BlogModule.blog',
                    'Write post!'
                ); ?></a>
        <?php endif; ?>
    </h1>

    <br/>

    <?php $this->widget(
        'bootstrap.widgets.TbListView',
        [
            'id'           => 'posts-list',
            'dataProvider' => $model->allPosts(),
            'itemView'     => '_item',
            'template'     => "{items}\n{pager}",
            'ajaxUpdate'   => false,
            'htmlOptions'  => [
                'class' => 'posts-list'
            ]
        ]
    ); ?>
</div>
