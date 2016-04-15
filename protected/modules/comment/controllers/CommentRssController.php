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
class CommentRssController extends yupe\components\controllers\RssController
{
    public function loadData()
    {
        $module = Yii::app()->getModule('comment');

        if (!($limit = (int)$module->rssCount)) {
            throw new CHttpException(404);
        }

        $model = Yii::app()->getRequest()->getQuery('model');
        $modelId = (int)Yii::app()->getRequest()->getQuery('modelId');

        if (empty($model) || empty($modelId)) {
            throw new CHttpException(404);
        }

        $models = $module->getModelsAvailableForRss();

        if(empty($models) || !in_array($model, $models)) {
            throw new CHttpException(404);
        }

        $this->title = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;

        $this->data = Yii::app()->commentManager->getCommentsForModel($model, $modelId);
    }

    public function actions()
    {
        return [
            'feed' => [
                'class' => 'yupe\components\actions\YFeedAction',
                'data' => $this->data,
                'title' => $this->title,
                'description' => $this->description,
                'itemFields' => [
                    'author_object' => false,
                    'author_nickname' => false,
                    'content' => 'text',
                    'datetime' => 'create_time',
                    'link' => false,
                    'linkParams' => ['title' => 'alias'],
                    'title' => false,
                    'updated' => 'create_time',
                ],
            ],
        ];
    }
}
