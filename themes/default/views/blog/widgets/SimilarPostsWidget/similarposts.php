<?php
/**
 * Отображение для SimilarPostsWidget/similarposts:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
if (count($posts) > 0) {
    echo CHtml::tag('b', array(), Yii::t('BlogModule.blog', 'Похожие записи:'));
    echo CHtml::openTag('ul');
    foreach ($posts as $post)
        echo CHtml::tag(
            'li', array(), CHtml::link(
                $post->title, array(
                    '/blog/post/show/',
                    'slug' => $post->slug
                )
            ) . ' <small>(' . Yii::app()->getDateFormatter()->formatDateTime(
                $post->publish_date, "short", "short"
            ) . ')</small>'
        );
    echo CHtml::closeTag('ul');
} else {
    echo CHtml::tag('b', array(), Yii::t('BlogModule.blog', 'Похожие записи не найдены'));
}