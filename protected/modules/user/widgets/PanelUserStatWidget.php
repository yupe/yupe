<?php

class PanelUserStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $dataProvider = new CActiveDataProvider('User', [
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
                'usersCount'    => User::model()->cache($cacheTime)->count(
                        'registration_date >= :time AND registration_date < NOW()',
                        [':time' => time() - 24 * 60 * 60]
                    ),
                'allUsersCnt'   => User::model()->cache($cacheTime)->count(),
                'registeredCnt' => User::model()->cache($cacheTime)->registered()->count(),
                'dataProvider'  => $dataProvider
            ]
        );
    }
}
