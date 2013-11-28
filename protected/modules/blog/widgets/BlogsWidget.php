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
 
class BlogsWidget extends YWidget
{
    public $view = 'blogswidget';

    public function run()
    { 
        $this->render($this->view, array('models' => Blog::model()->public()->published()->cache($this->cacheTime)->with('membersCount','postsCount')->cache($this->cacheTime)->findAll(array('limit' => $this->limit))));
    }
}
