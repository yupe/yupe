<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Posts archive'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'archive'),
); ?>

<p><?php echo Yii::t('BlogModule.blog', 'Posts archive'); ?></p>

<?php foreach ($data as $year => $element): ?>
    <h2><?php echo $year; ?></h2>
    <?php foreach ($element as $month => $posts): ?>
        <h3><?php echo Yii::app()->getDateFormatter()->format('LLLL', "01.{$month}.{$year}"); ?></h3>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <span><?php echo Yii::app()->getDateFormatter()->formatDateTime(
                            $post['publish_date'],
                            'long',
                            false
                        ); ?></span>
                    <?php echo CHtml::link(
                        CHtml::encode($post['title']),
                        array('/blog/post/show/', 'slug' => CHtml::encode($post['slug']))
                    ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
<?php endforeach; ?>
