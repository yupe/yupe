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

class BlogsWidget extends YWidget
{
    public function run()
    {
        $this->render('blogswidget', array('models' => Blog::model()->public()->published()->cache($this->cacheTime)->findAll()));
    }
}
