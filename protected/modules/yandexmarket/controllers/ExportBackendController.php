<?php

class ExportBackendController extends yupe\components\controllers\BackController
{
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

    public function actionCreate()
    {
        $model = new Export();

        if (($data = Yii::app()->getRequest()->getPost('Export')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YandexMarketModule.default', 'Record was created!')
                );

                $this->redirect((array)Yii::app()->getRequest()->getPost('submit-type', ['create']));
            }
        }

        $this->render('create', ['model' => $model]);
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Export')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YandexMarketModule.default', 'Record was updated!')
                );

                $this->redirect((array)Yii::app()->getRequest()->getPost('submit-type', ['update', 'id' => $model->id,]));
            }
        }

        $this->render('update', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->loadModel($id)->delete();
                $transaction->commit();
                if (!isset($_GET['ajax'])) {
                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            }
        } else {
            throw new CHttpException(
                400,
                Yii::t('YandexMarketModule.default', 'Unknown request. Don\'t repeat it please!')
            );
        }
    }


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
            throw new CHttpException(404, Yii::t('YandexMarketModule.default', 'Page not found!'));
        }
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel $model - модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(Attribute $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'export-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
