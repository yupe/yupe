<?php

class ProducerBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Producer',
                'validAttributes' => array(
                    'status',
                    'slug'
                )
            )
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Store.ProducerBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Store.ProducerBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Store.ProducerBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Store.ProducerBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Store.ProducerBackend.View'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    public function actionCreate()
    {
        $model = new Producer();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Producer'])) {
            $model->attributes = $_POST['Producer'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.producer', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Producer'])) {
            $model->attributes = $_POST['Producer'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.producer', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('StoreModule.producer', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('StoreModule.producer', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }

    public function actionIndex()
    {
        $model = new Producer('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Producer'])) {
            $model->attributes = $_GET['Producer'];
        }
        $this->render('index', array('model' => $model));
    }

    public function loadModel($id)
    {
        $model = Producer::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.producer', 'Запрошенная страница не найдена.'));
        }
        return $model;
    }


    protected function performAjaxValidation(Producer $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'producer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
