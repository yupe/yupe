<?php

/**
 * BlogRssController контроллер для rss на публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class BlogRssController extends yupe\components\controllers\RssController
{
    public function loadData()
    {
        if (!($limit = (int)$this->module->rssCount)) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria();
        $criteria->order = 'publish_time DESC';
        $criteria->params = [];
        $criteria->limit = $limit;

        $yupe = Yii::app()->getModule('yupe');

        $this->title = $yupe->siteName;
        $this->description = $yupe->siteDescription;

        $blogId = (int)Yii::app()->getRequest()->getQuery('blog');

        if (!empty($blogId)) {
            $blog = Blog::model()->cache($yupe->coreCacheTime)->published()->findByPk($blogId);
            if (null === $blog) {
                throw new CHttpException(404);
            }
            $this->title = $blog->name;
            $this->description = $blog->description;
            $criteria->addCondition('blog_id = :blog_id');
            $criteria->params[':blog_id'] = $blogId;
        }

        $categoryId = (int)Yii::app()->getRequest()->getQuery('category');

        if (!empty($categoryId)) {
            $category = Category::model()->cache($yupe->coreCacheTime)->published()->findByPk($categoryId);
            if (null === $category) {
                throw new CHttpException(404);
            }
            $this->title = $category->name;
            $this->description = $category->description;
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $categoryId;
        }

        $tag = Yii::app()->getRequest()->getQuery('tag');

        if (!empty($tag)) {
            $this->data = Post::model()->with('createUser')->published()->public()->taggedWith($tag)->findAll();
        } else {
            $this->data = Post::model()->cache($yupe->coreCacheTime)->with('createUser')->published()->public(
            )->findAll($criteria);
        }
    }

    public function actions()
    {
        return [
            'feed' => [
                'class'       => 'yupe\components\actions\YFeedAction',
                'data'        => $this->data,
                'title'       => $this->title,
                'description' => $this->description,
                'itemFields'  => [
                    'author_object'   => 'createUser',
                    'author_nickname' => 'nick_name',
                    'content'         => 'content',
                    'datetime'        => 'create_time',
                    'link'            => '/blog/post/view',
                    'linkParams'      => ['slug' => 'slug'],
                    'title'           => 'title',
                    'updated'         => 'update_time',
                ],
            ],
        ];
    }
}
