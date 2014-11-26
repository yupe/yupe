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
        $model::model()->resetAllTagsCache();
        $criteria = new CDbCriteria();
        $criteria->order = 'count DESC';
        $criteria->limit = $this->count;
        $this->render('tagcloud', ['tags' => $model::model()->getAllTagsWithModelsCount($criteria)]);
    }
}
