<?php

/**
 * LastPostsWidget виджет для вывода последних записей
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
 * Class LastPostsWidget
 */
class LastPostsWidget extends yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'lastposts';

    /**
     * @var
     */
    public $criteria;

    /**
     * @throws CException
     */
    public function run()
    {
        $criteria = [
            'limit' => $this->limit,
            'order' => 't.id DESC',
        ];

        if (is_array($this->criteria) && !empty($this->criteria)) {
            $criteria = CMap::mergeArray($criteria, $this->criteria);
        }

        $posts = Post::model()->published()->with('createUser', 'commentsCount', 'blog')->public()->cache(
            $this->cacheTime
        )->findAll($criteria);

        $this->render($this->view, ['models' => $posts]);
    }
}
