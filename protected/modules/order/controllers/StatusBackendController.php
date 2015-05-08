<?php

class StatusBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Order.StatusBackend.Index'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Order.StatusBackend.Create'],],
            ['allow', 'actions' => ['update'], 'roles' => ['Order.StatusBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Order.StatusBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionIndex()
    {
        $model = new OrderStatus('search');
        $model->unsetAttributes();

        if ($data = Yii::app()->getRequest()->getQuery('OrderStatus')) {
            $model->setAttributes($data);
        }

        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new OrderStatus();

        if (Yii::app()->getRequest()->getIsPostrequest() && $data = Yii::app()->getRequest()->getPost('OrderStatus')) {

            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Record created!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getIsPostrequest() && $data = Yii::app()->getRequest()->getPost('OrderStatus')) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('OrderModule.order', 'Record updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('OrderModule.order', 'Record removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'OrderModule.order',
                'Unknown request. Don\'t repeat it please!'
            ));
        }
    }

    /**
     * @param $id
     * @return OrderStatus
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = OrderStatus::model()->findByPk($id, 'is_system != 1');
        if ($model === null) {
            throw new CHttpException(404, Yii::t('OrderModule.order', 'Page not found!'));
        }

        return $model;
    }

}