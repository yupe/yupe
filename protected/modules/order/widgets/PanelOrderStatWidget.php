<?php

class PanelOrderStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['status'];

        $dataProvider = new CActiveDataProvider(
            'Order', [
                'criteria' => $criteria,
                'sort' => [
                    'defaultOrder' => 't.id DESC',
                ],
                'pagination' => [
                    'pageSize' => (int)$this->limit,
                ],
            ]
        );

        $cacheTime = Yii::app()->getController()->yupe->coreCacheTime;
        $model = Order::model();
        $dependency = new CDbCacheDependency('select max(modified) from ' . Order::model()->tableName());

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
