<?php

/**
 * CommentRssController контроллер для генерации rss-ленты комментариев
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.comment.controllers
 * @since 0.1
 *
 */

class CommentRssController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        if (!($limit = (int) Yii::app()->getModule('news')->rssCount)) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria;
        $criteria->order = 't.creation_date DESC';
        $criteria->params = array();
        $criteria->limit = $limit;

        $yupe = Yii::app()->getModule('yupe');

        $title = $yupe->siteName;
        $description = $yupe->siteDescription;

        $model = Yii::app()->getRequest()->getQuery('model');
        $modelId = (int)Yii::app()->getRequest()->getQuery('modelId');

        if(empty($model) || empty($modelId)) {
            throw new CHttpException(404);
        }

        $criteria->addCondition('model = :model')
            ->addCondition('model_id = :modelId')
            ->addCondition('t.id<>t.root');

        $criteria->params = array(
            ':model'    => $model,
            ':modelId'  => $modelId,
        );

        $data = Comment::model()->cache($yupe->coreCacheTime)->approved()->with('author')->findAll($criteria);

        return array(
            'feed' => array(
                'class' => 'yupe\components\actions\YFeedAction',
                'data' => $data,
                'title' => $title,
                'description' => $description,
                'itemFields' => array(
                    'author_object' => false,
                    'author_nickname' => false,
                    'content' => 'text',
                    'datetime' => 'creation_date',
                    'link' => false,
                    'linkParams' => array('title' => 'alias'),
                    'title' => false,
                    'updated' => 'creation_date',
                ),
            ),
        );
    }
}