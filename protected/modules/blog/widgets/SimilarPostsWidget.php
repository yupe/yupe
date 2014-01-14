<?php

/**
 * SimilarPostsWidget виджет для вывода похожих постов
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
Yii::import('application.modules.blog.models.*');

class SimilarPostsWidget extends yupe\widgets\YWidget
{
    public $limit = 10;

    public $post;

    public $view = 'similarposts';

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'publish_date DESC';

        $criteria->addNotInCondition('t.id', array($this->post->id));

        $criteria->mergeWith(
            Post::model()->getFindByTagsCriteria($this->post->getTags())
        );
        
        $posts = Post::model()->findAll(
            $criteria
        );

        $this->render($this->view, array('posts' => $posts));
    }
}