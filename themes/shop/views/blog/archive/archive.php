<?php $this->title = Yii::t('BlogModule.blog', 'Posts archive'); ?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'archive'),
]; ?>

<p><?= Yii::t('BlogModule.blog', 'Posts archive'); ?></p>

<?php foreach ($data as $year => $element): ?>
    <h2><?= $year; ?></h2>
    <?php foreach ($element as $month => $posts): ?>
        <h3><?= Yii::app()->getDateFormatter()->format('LLLL', "01.{$month}.20{$year}"); ?></h3>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <span><?= Yii::app()->getDateFormatter()->formatDateTime(
                            $post['publish_time'],
                            'long',
                            false
                        ); ?></span>
                    <?= CHtml::link(
                        CHtml::encode($post['title']),
                        ['/blog/post/view/', 'slug' => CHtml::encode($post['slug'])]
                    ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
<?php endforeach; ?>
