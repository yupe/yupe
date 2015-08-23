<?php

/**
 * NewsRssController контроллер для генерации rss-ленты новостей
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.news.controllers
 * @since 0.1
 *
 */
class NewsRssController extends yupe\components\controllers\RssController
{
    public function loadData()
    {
        if (!($limit = (int)$this->module->rssCount)) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria();
        $criteria->order = 'date DESC';
        $criteria->params = [];
        $criteria->limit = $limit;

        $this->title = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;

        $categoryId = (int)Yii::app()->getRequest()->getQuery('category');

        if (!empty($categoryId)) {
            $category = Category::model()->cache($this->yupe->coreCacheTime)->published()->findByPk($categoryId);
            if (null === $category) {
                throw new CHttpException(404);
            }
            $this->title = $category->name;
            $this->description = $category->description;
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $categoryId;
        }

        $this->data = News::model()->cache($this->yupe->coreCacheTime)->with('user')->published()->public()->findAll(
            $criteria
        );
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
                    'author_object'   => 'user',
                    'author_nickname' => 'nick_name',
                    'content'         => 'short_text',
                    'datetime'        => 'date',
                    'link'            => '/news/news/view',
                    'linkParams'      => ['title' => 'slug'],
                    'title'           => 'title',
                    'updated'         => 'update_time',
                ],
            ],
        ];
    }
}
