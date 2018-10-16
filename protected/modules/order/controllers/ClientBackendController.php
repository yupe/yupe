<?php

use yupe\components\controllers\BackController;

/**
 * Class ClientBackendController
 */
class ClientBackendController extends BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Order.clientBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Order.clientBackend.View'],],
            ['allow', 'actions' => ['create', 'productRow'], 'roles' => ['Order.clientBackend.Create'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Order.clientBackend.Delete'],],
            ['deny',],
        ];
    }


    /**
     *
     */
    public function actionIndex()
    {
        $model = new Client('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->getRequest()->getQuery('Client')) {
            $model->setAttributes(Yii::app()->getRequest()->getQuery('Client'));
        }
        $this->render('index', ['model' => $model]);
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $model = Client::model()->findByPk($id);

        if (null === $model) {
            throw new CHttpException(404);
        }

        $this->render('view', ['model' => $model, 'order' => new Order(), 'orders' => $model->getOrders()]);
    }
}