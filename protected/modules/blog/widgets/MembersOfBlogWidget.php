<?php

/**
 * MembersOfBlogWidget виджет для вывода участников блога
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */

Yii::import('application.modules.blog.models.*');  
 
class MembersOfBlogWidget extends YWidget
{
    public $blogId;

    public $view = 'membersofblog';

    public function run()
    {
        $blog = Blog::model()->with('members')->findByPk($this->blogId);

        $this->render($this->view, array('model' => $blog));
    }
}