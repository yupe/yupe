<?php

/**
 * Class UserController
 */
class UserController extends \yupe\components\controllers\FrontController
{
    /**
     * @return array
     */
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'actions' => ['index'], 'users' => ['@'],],
            ['deny', 'users' => ['*'],],
        ];
    }

    /**
     *
     */
    public function actionIndex()
    {
        $this->render(
            'index',
            [
                'orders' => Order::model()->findAllByAttributes(
                    ['user_id' => Yii::app()->getUser()->getId()],
                    ['order' => 'date DESC']
                ),
            ]
        );
    }
}
