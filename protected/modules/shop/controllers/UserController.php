<?php

class UserController extends yupe\components\controllers\FrontController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $orders = Order::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id), array('order' => 'date DESC'));
        $this->render('index', array('orders' => $orders));
    }
}
