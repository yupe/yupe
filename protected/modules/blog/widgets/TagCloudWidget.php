<?php

class TagCloudWidget extends yupe\widgets\YWidget
{
    public $count = 50;
    public $model;

    public function run()
    {
        if (!@class_exists($this->model)) {
            echo CHtml::tag(
                'p',
                [
                    'class' => 'alert alert-error'
                ],
                Yii::t(
                    'YupeModule.yupe',
                    'Widget {widget}: Model "{model}" was not found!',
                    [
                        '{model}'  => $this->model,
                        '{widget}' => get_class($this),
                    ]
                )
            );

            return false;
        }
        $model = $this->model;
        $model::model()->resetAllTagsWithModelsCountCache();

        $criteria = new CDbCriteria();
        $criteria->order = 'count DESC';
        $criteria->limit = $this->count;

        if ($model == 'Post') {
            $criteria->join = 'JOIN ' . $model::model()->tableName() . ' p ON et.post_id = p.id';
            $criteria->condition = 'p.status = :status';
            $criteria->addCondition('p.access_type = :access');
            $criteria->params = [
                ':status' => $model::STATUS_PUBLISHED,
                ':access' => $model::ACCESS_PUBLIC,
            ];
        }

        $this->render('tagcloud', ['tags' => $model::model()->getAllTagsWithModelsCount($criteria)]);
    }
}
