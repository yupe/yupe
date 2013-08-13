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
        $criteria->order = 't.creation_date DESC';
        $criteria->params = array();
        $criteria->limit = $limit;

        $title = $this->yupe->siteName;
        $description = $this->yupe->siteDescription;

        $model = Yii::app()->request->getQuery('model');
        $modelId = (int)Yii::app()->request->getQuery('modelId');

        if(empty($model) || empty($modelId)) {
            throw new CHttpException(404);
        }

        $criteria->addCondition('model = :model')
            ->addCondition('model_id = :modelId');

        $criteria->params = array(
            ':model'    => $model,
            ':modelId'  => $modelId,
        );

        $data = Comment::model()->cache($this->yupe->coreCacheTime)->approved()->with('author')->findAll($criteria);

        return array(
            'feed' => array(
                'class' => 'application.modules.yupe.components.actions.YFeedAction',
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