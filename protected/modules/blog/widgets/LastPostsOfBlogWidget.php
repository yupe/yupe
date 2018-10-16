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

/**
 * Class LastPostsOfBlogWidget
 */
class LastPostsOfBlogWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $blogId;

    /**
     * @var string
     */
    public $view = 'lastpostsofblog';

    /**
     * @var
     */
    public $postId;

    /**
     * @throws CException
     */
    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('blog_id = :blog_id');
        $criteria->limit = (int)$this->limit;
        $criteria->params = [
            ':blog_id' => (int)$this->blogId
        ];

        if ($this->postId) {
            $criteria->addCondition('t.id != :post_id');
            $criteria->params[':post_id'] = (int)$this->postId;
        }

        $this->render(
            $this->view,
            [
                'posts' => Post::model()->public()->published()->sortByPubDate('DESC')->with(
                        'commentsCount',
                        'createUser',
                        'blog'
                    )->findAll($criteria)
            ]
        );
    }
}
