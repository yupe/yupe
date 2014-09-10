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
        $this->render($this->view, ['posts' => Yii::app()->postManager->getSimilarPosts($this->post, $this->limit)]);
    }
}
