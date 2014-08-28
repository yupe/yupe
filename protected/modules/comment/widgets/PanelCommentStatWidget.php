<?php

class PanelCommentStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('level <> 1');

        $dataProvider = new CActiveDataProvider('Comment', array(
            'criteria'   => $criteria,
            'sort'       => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => (int)$this->limit,
            ),
        ));

        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;

        $this->render(
            'panel-stat',
            array(
                'commentsCount'  => Comment::model()->cache($cacheTime)->count(
                        'creation_date >= :time AND level <> 1',
                        array(':time' => time() - 24 * 60 * 60)
                    ),
                'allCommentsCnt' => Comment::model()->cache($cacheTime)->all()->count(),
                'newCnt'         => Comment::model()->cache($cacheTime)->new()->count(),
                'dataProvider'   => $dataProvider
            )
        );
    }
}
