<?php

class PanelStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $dataProvider = new CActiveDataProvider('Post', [
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
                'postsCount'    => Post::model()->cache($cacheTime)->count(
                        'create_time >= :time',
                        [':time' => time() - 24 * 60 * 60]
                    ),
                'allPostsCnt'   => Post::model()->cache($cacheTime)->count(),
                'moderationCnt' => Post::model()->cache($cacheTime)->moderated()->count(),
                'dataProvider'  => $dataProvider
            ]
        );
    }
}
