<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 6/15/13
 * Time: 7:53 PM
 * To change this template use File | Settings | File Templates.
 */

class RssController extends YFrontController
{
    public function actions()
    {
        if (!($limit = (int)$this->module->rssCount)) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria;
        $criteria->order = 'publish_date DESC';
        $criteria->params = array();
        $criteria->limit = $limit;

        $title = $this->yupe->siteName;
        $description = $this->yupe->siteDescription;

        $blogId = (int)Yii::app()->request->getQuery('blog');

        if (!empty($blogId)) {
            $blog = Blog::model()->cache($this->yupe->coreCacheTime)->published()->findByPk($blogId);
            if (null === $blog) {
                throw new CHttpException(404);
            }
            $title = $blog->name;
            $description = $blog->description;
            $criteria->addCondition('blog_id = :blog_id');
            $criteria->params[':blog_id'] = $blogId;
        }

        $categoryId = (int)Yii::app()->request->getQuery('category');

        if (!empty($categoryId)) {
            $category = Category::model()->cache($this->yupe->coreCacheTime)->published()->findByPk($categoryId);
            if (null === $category) {
                throw new CHttpException(404);
            }
            $title = $category->name;
            $description = $category->description;
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $categoryId;
        }

        $tag = Yii::app()->request->getQuery('tag');

        if (!empty($tag)) {
            $data = Post::model()->with('createUser')->published()->public()->taggedWith($tag)->findAll();
        } else {
            $data = Post::model()->cache($this->yupe->coreCacheTime)->with('createUser')->published()->public(
            )->findAll($criteria);
        }

        return array(
            'feed' => array(
                'class' => 'application.modules.yupe.components.actions.YFeedAction',
                'data' => $data,
                'title' => $title,
                'description' => $description,
                'itemFields' => array(
                    // author_object, если не задан - у
                    // item-елемента запросится author_nickname
                    'author_object' => 'createUser',
                    // 'author_nickname' => 'nick_name',
                    'author_nickname' => 'nick_name',
                    'content' => 'content',
                    'datetime' => 'create_date',
                    'link' => '/blog/post/show',
                    'linkParams' => array('slug' => 'slug'),
                    'title' => 'title',
                    'updated' => 'update_date',
                ),
            ),
        );
    }
}