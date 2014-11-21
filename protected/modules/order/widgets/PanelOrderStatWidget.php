<?php

class PanelOrderStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $criteria = new CDbCriteria();

        $dataProvider = new CActiveDataProvider(
            'Order', [
                'criteria' => $criteria,
                'sort' => [
                    'defaultOrder' => 'id DESC',
                ],
                'pagination' => [
                    'pageSize' => (int)$this->limit,
                ],
            ]
        );

        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;
        $model = Order::model();
        $dependency = new CDbCacheDependency('select max(modified) from ' . $model->tableName());

        $this->render(
            'panel-stat',
            [
                'ordersCount' => $model->cache($cacheTime, $dependency)->count(),
                'newOrdersCount' => $model->cache($cacheTime, $dependency)->new()->count(),
                'dataProvider' => $dataProvider
            ]
        );
    }
}
