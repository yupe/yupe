<?php
/**
 * Отображение для blog/widgets/lastpostsofblog:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if ($model === null) :
    echo Yii::t('BlogModule.blog', 'Блог не существует');
elseif (count($model->posts) > 0) : ?>
    <p><?php echo Yii::t('BlogModule.blog', 'Последние записи'); ?>:</p>
    <ul>
        <?php foreach ($model->posts as $post) : ?>
            <li>
                <?php echo CHtml::link($post->title, array('/blog/post/show/', 'slug' => $post->slug)); ?> 
                - <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", null); ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else : ?>
    <?php echo Yii::t('BlogModule.blog', 'Записей нет'); ?>
<?php endif; ?>