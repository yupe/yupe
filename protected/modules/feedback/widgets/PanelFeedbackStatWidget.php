<?php

class PanelFeedbackStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $dataProvider = new CActiveDataProvider('FeedBack', array(
            'sort'       => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => (int)$this->limit,
            ),
        ));

        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;

        $this->render(
            'panel-feedback-stat',
            array(
                'feedbackCount'    => FeedBack::model()->cache($cacheTime)->count(
                        'creation_date >= :time',
                        array(':time' => time() - 24 * 60 * 60)
                    ),
                'allFeedbackCount' => FeedBack::model()->cache($cacheTime)->count(),
                'needAnswerCount'  => FeedBack::model()->new()->cache($cacheTime)->count(),
                'dataProvider'     => $dataProvider
            )
        );
    }
}
