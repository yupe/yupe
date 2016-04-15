<?php

/**
 * BlogsWidget виджет для вывода блогов
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */

Yii::import('application.modules.blog.models.Blog');

class BlogsWidget extends yupe\widgets\YWidget
{
    public $view = 'blogswidget';

    public function run()
    {
        $models = Blog::model()->public()->published()->cache($this->cacheTime)->with(
            'membersCount',
            'postsCount'
        )->cache($this->cacheTime)->findAll(
                [
                    'join'   => 'LEFT JOIN {{blog_user_to_blog}} utb ON utb.blog_id = t.id',
                    'select' => 't.name, t.slug',
                    'order'  => 'count(utb.id) DESC',
                    'group'  => 't.slug, t.name, t.id',
                    'limit'  => $this->limit,
                ]
            );

        $this->render($this->view, ['models' => $models]);
    }
}
