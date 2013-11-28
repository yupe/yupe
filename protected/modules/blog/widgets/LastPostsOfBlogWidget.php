<?php

/**
 * LastPostsOfBlogWidget виджет для вывода последних записей блога
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
Yii::import('application.modules.blog.models.*'); 
 
class LastPostsOfBlogWidget extends YWidget
{
    public $blogId;

    public $view = 'lastpostsofblog';

    public function run()
    {
        $posts = Post::model()->public()->published()->findAll(array(
                'condition' => 'blog_id = :blog_id',
                'limit'  => (int)$this->limit,
                'order'  => 'publish_date DESC',
                'params' => array(
                    ':blog_id' => (int)$this->blogId
                )
        ));

        $this->render($this->view, array('posts' => $posts));
    }
}