<?php

class PanelCommentStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('level <> 1');

        $dataProvider = new CActiveDataProvider('Comment', [
            'criteria'   => $criteria,
            'sort'       => [
                'defaultOrder' => 'id DESC',
            ],
            'pagination' => [
                'pageSize' => (int)$this->limit,
            ],
        ]);

        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;

        $this->render(
            'panel-stat',
            [
                'commentsCount'  => Comment::model()->cache($cacheTime)->count(
                        'create_time >= :time AND level <> 1',
                        [':time' => time() - 24 * 60 * 60]
                    ),
                'allCommentsCnt' => Comment::model()->cache($cacheTime)->all()->count(),
                'newCnt'         => Comment::model()->cache($cacheTime)->new()->count(),
                'dataProvider'   => $dataProvider
            ]
        );
    }
}
