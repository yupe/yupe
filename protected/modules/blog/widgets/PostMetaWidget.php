<?php

/**
 * PostMetaWidget виджет для вывода мета-информации о посте
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
class PostMetaWidget extends yupe\widgets\YWidget
{
    public $post;

    public $view = 'post-meta';

    public function run()
    {
        $this->render($this->view, ['post' => $this->post]);
    }
}
