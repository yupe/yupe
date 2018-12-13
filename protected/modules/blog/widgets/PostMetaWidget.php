<?php

/**
 * PostMetaWidget виджет для вывода мета-информации о посте
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
class PostMetaWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $post;

    /**
     * @var string
     */
    public $view = 'post-meta';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['post' => $this->post]);
    }
}
