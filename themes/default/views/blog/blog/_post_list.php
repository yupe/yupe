<?php
/**
 * Отображение для blog/_post_list:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if (count($posts)) : ?>
    <p><?php echo Yii::t('blog', 'Последние записи'); ?>:</p>
    <ul>
        <?php foreach ($posts as $post) : ?>
            <li>
                <?php echo CHtml::link($post->title, array('/blog/post/show/', 'slug' => $post->slug)); ?> 
                - <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", null); ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php endif; ?>