<?php

/**
 * Class PanelOrderStatWidget
 */
class PanelOrderStatWidget extends \yupe\widgets\YWidget
{
    /**
     * @throws CException
     */
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
        $dependency = new CDbCacheDependency('select max(modified) from {{store_order}}');

        $this->render(
            'panel-stat',
            [
                'ordersCount' => $model->cache($cacheTime, $dependency)->count(),
                'newOrdersCount' => $model->cache($cacheTime, $dependency)->new()->count(),
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
