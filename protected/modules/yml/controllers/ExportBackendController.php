<?php

/**
 * Class ExportBackendController
 */
class ExportBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['YandexMarket.ExportBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['YandexMarket.ExportBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['YandexMarket.ExportBackend.Create'],],
            ['allow', 'actions' => ['update'], 'roles' => ['YandexMarket.ExportBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['YandexMarket.ExportBackend.Delete'],],
            ['deny',],
        ];
    }

    /**
     *
     */
    public function actionCreate()
    {
        $model = new Export();
        $model->setAttributes([
            'shop_platform' => Yii::app()->name,
            'shop_version' => Yii::app()->getModule('yupe')->version,
        ]);

        if (($data = Yii::app()->getRequest()->getPost('Export')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YmlModule.default', 'Record was created!')
                );

                $this->redirect((array)Yii::app()->getRequest()->getPost('submit-type', ['create']));
            }
        }

        $this->render('create', ['model' => $model]);
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Export')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YmlModule.default', 'Record was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost('submit-type', ['update', 'id' => $model->id,])
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();
        }
    }


    /**
     *
     */
    public function actionIndex()
    {
        $model = new Export('search');
        $model->unsetAttributes();

        if (isset($_GET['Export'])) {
            $model->attributes = $_GET['Export'];
        }

        $this->render('index', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Export
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Export::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('YmlModule.default', 'Page not found!'));
        }

        return $model;
    }
}
