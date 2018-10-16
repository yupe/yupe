<?php

/**
 * Class PanelFeedbackStatWidget
 */
class PanelFeedbackStatWidget extends \yupe\widgets\YWidget
{
    /**
     * @throws CException
     */
    public function run()
    {
        $dataProvider = new CActiveDataProvider('FeedBack', [
            'sort'       => [
                'defaultOrder' => 'id DESC',
            ],
            'pagination' => [
                'pageSize' => (int)$this->limit,
            ],
        ]);

        $cacheTime = Yii::app()->getController()->yupe->coreCacheTime;

        $this->render(
            'panel-feedback-stat',
            [
                'feedbackCount'    => FeedBack::model()->cache($cacheTime)->count(
                        'create_time >= :time',
                        [':time' => time() - 24 * 60 * 60]
                    ),
                'allFeedbackCount' => FeedBack::model()->cache($cacheTime)->count(),
                'needAnswerCount'  => FeedBack::model()->new()->cache($cacheTime)->count(),
                'dataProvider'     => $dataProvider
            ]
        );
    }
}
