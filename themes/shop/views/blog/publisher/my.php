<div class="page-header">
    <h1>
        <small><?= Yii::t('BlogModule.blog', 'My posts'); ?></small>
        <a class="btn btn-warning pull-right"
           href="<?= Yii::app()->createUrl('/blog/publisher/write'); ?>"><?= Yii::t(
                'BlogModule.blog',
                'Write post!'
            ); ?></a>
    </h1>
</div>
