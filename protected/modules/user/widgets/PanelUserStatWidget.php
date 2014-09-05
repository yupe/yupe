<?php

class PanelUserStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $dataProvider = new CActiveDataProvider('User', array(
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
                'usersCount'    => User::model()->cache($cacheTime)->count(
                        'registration_date >= :time AND registration_date < NOW()',
                        array(':time' => time() - 24 * 60 * 60)
                    ),
                'allUsersCnt'   => User::model()->cache($cacheTime)->count(),
                'registeredCnt' => User::model()->cache($cacheTime)->registered()->count(),
                'dataProvider'  => $dataProvider
            )
        );
    }
}
