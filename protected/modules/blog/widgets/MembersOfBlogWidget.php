<?php

/**
 * MembersOfBlogWidget виджет для вывода участников блога
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
 * Class MembersOfBlogWidget
 */
class MembersOfBlogWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $blogId;

    /**
     * @var
     */
    public $blog;

    /**
     * @var string
     */
    public $view = 'membersofblog';

    /**
     * @throws CException
     */
    public function run()
    {
        if (!$this->blog) {
            $this->blog = Blog::model()->with('members')->findByPk($this->blogId);
        }

        $this->render($this->view, ['model' => $this->blog]);
    }
}
