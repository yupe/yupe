<?php

class CallbackBackendController extends \yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Callback',
                'validAttributes' => [
                    'status',
                    'comment'
                ]
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Callback.CallbackBackend.Index'],],
            ['allow', 'actions' => ['inline'], 'roles' => ['Callback.CallbackBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Callback.CallbackBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actionIndex()
    {
        $model = new Callback('search');

        $model->unsetAttributes();

        if ($data = Yii::app()->getRequest()->getQuery('Callback')) {
            $model->setAttributes($data);
        }

        $this->render('index', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('CallbackModule.callback', 'Record removed!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'CallbackModule.callback',
                'Unknown request. Don\'t repeat it please!'
            ));
        }
    }

    /**
     * @param $id
     * @return Callback
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Callback::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CallbackModule.callback', 'Page not found!'));
        }

        return $model;
    }
}