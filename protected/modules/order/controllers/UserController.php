<?php

class UserController extends \yupe\components\controllers\FrontController
{
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'actions' => ['index'], 'users' => ['@'],],
            ['deny', 'users' => ['*'],],
        ];
    }

    public function actionIndex()
    {
        $this->render(
            'index',
            [
                'orders' => Order::model()->findAllByAttributes(
                        ['user_id' => Yii::app()->getUser()->getId()],
                        ['order' => 'date DESC']
                    )
            ]
        );
    }
}
