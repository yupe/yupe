<?php

/**
 * LastPostsWidget виджет для вывода последних записей
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */

class LastPostsWidget extends YWidget
{
    public $view = 'lastposts';

    public function run()
    {
        $posts = Post::model()->published()->public()->cache($this->cacheTime)->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render($this->view, array('models' =>$posts));
    }
}