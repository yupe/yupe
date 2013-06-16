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
        $blogId = (int)Yii::app()->request->getQuery('blog');
        $categoryId = (int)Yii::app()->request->getQuery('category');

        $criteria = new CDbCriteria;
        $criteria->order = 'publish_date DESC';
        $criteria->params = array();

        if(!empty($blogId)){
            $criteria->addCondition('blog_id = :blog_id');
            $criteria->params[':blog_id'] = $blogId;
        }

        if(!empty($categoryId)){
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $categoryId;
        }

        $data = Post::model()->cache($this->yupe->coreCacheTime)->published()->findAll($criteria);

        return array(
            'feed' => array(
                'class'=> 'application.modules.yupe.components.actions.YFeedAction',
                'data' => $data,
                'link' => 'http://yupe.ru/',
                'itemFields'   => array(
                    // author_object, если не задан - у
                    // item-елемента запросится author_nickname
                    'author_object'   => 'createUser',
                    // 'author_nickname' => 'nick_name',
                    'author_nickname' => 'nick_name',
                    'content'         => 'content',
                    'datetime'        => 'create_date',
                    'link'            => '/blog/post/show',
                    'linkParams'      => array('slug' => 'slug'),
                    'title'           => 'title',
                    'updated'         => 'update_date',
                ),
            ),
        );
    }
}