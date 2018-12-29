<?php

/**
 * SimilarPostsWidget виджет для вывода похожих постов
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
Yii::import('application.modules.blog.models.*');

/**
 * Class SimilarPostsWidget
 */
class SimilarPostsWidget extends yupe\widgets\YWidget
{
    /**
     * @var int
     */
    public $limit = 10;

    /**
     * @var
     */
    public $post;

    /**
     * @var string
     */
    public $view = 'similarposts';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['posts' => Yii::app()->postManager->getSimilarPosts($this->post, $this->limit)]);
    }
}
