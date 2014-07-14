<?php

Yii::import('catalog.controllers.CatalogController');

class ShopController extends CatalogController
{
    public function actionIndex() {
        $this->layout = '//layouts/column2';
        $dataProvider = new CActiveDataProvider(Good::model()->published(), array(
            'criteria' => new CDbCriteria(array(
                    'limit' => self::GOOD_PER_PAGE,
                    'order' => 't.create_time DESC',
                )),
        ));

        $this->render('index', array('dataProvider' => $dataProvider));
    }
}