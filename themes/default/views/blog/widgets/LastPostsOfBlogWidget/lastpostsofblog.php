<?php if(!empty($posts)):?>
    <p><?php echo Yii::t('BlogModule.blog', 'Последние записи'); ?> <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/',array('blog' => $this->blogId));?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/web/images/rss.png" alt="Подпишитесь на обновление блога" title="Подпишитесь на обновление блога"></a></p>
    <ul>
        <?php foreach ($posts as $post) : ?>
            <li>
                <?php echo CHtml::link($post->title, array('/blog/post/show/', 'slug' => $post->slug)); ?>
                - <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", null); ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else : ?>
    <?php echo Yii::t('BlogModule.blog', 'Записей пока нет =('); ?>
<?php endif; ?>