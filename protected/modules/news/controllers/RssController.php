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
        $criteria->order = 'date DESC';
        $criteria->params = array();
        $criteria->limit = $limit;

        $title = $this->yupe->siteName;
        $description = $this->yupe->siteDescription;

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

        $data = News::model()->cache($this->yupe->coreCacheTime)->with('user')->published()->public()->findAll($criteria);

        return array(
            'feed' => array(
                'class' => 'application.modules.yupe.components.actions.YFeedAction',
                'data' => $data,
                'title' => $title,
                'description' => $description,
                'itemFields' => array(
                    'author_object' => 'user',
                    'author_nickname' => 'nick_name',
                    'content' => 'short_text',
                    'datetime' => 'date',
                    'link' => '/news/news/show',
                    'linkParams' => array('title' => 'alias'),
                    'title' => 'title',
                    'updated' => 'change_date',
                ),
            ),
        );
    }
}