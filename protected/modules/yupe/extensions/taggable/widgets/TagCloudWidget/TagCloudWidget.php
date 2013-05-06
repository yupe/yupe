<?php
class TagCloudWidget extends YWidget
{
    public $count = 10;
    public $model;

    public function run()
    {
        if (!@class_exists($this->model)) {
            echo CHtml::tag(
                'p', array(
                    'class' => 'alert alert-error'
                ), Yii::t(
                    'YupeModule.yupe', 'Виджет {widget}: Модель "{model}" не найдена!', array(
                        '{model}'  => $this->model,
                        '{widget}' => get_class($this),
                    )
                )
            );
            return false;
        }
        $model = $this->model;
        $model::model()->resetAllTagsCache();

        $criteria = new CDbCriteria;
        $criteria->order = '"count" DESC';
        $criteria->limit = $this->count;

        $tags = $model::model()->getAllTagsWithModelsCount($criteria);

        $total = 0;

        foreach ($tags as $tag)
            $total += $tag['count'];

        $outtags = array();

        if ($total > 0) {
            foreach ($tags as $tag)
                $outtags[$tag['name']] = 8 + (int) (16 * $tag['count'] / ($total + 10));
            ksort($outtags);
        }

        $this->render('tagcloud', array('tags' => $outtags));
    }
}
