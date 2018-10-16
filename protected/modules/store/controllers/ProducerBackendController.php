<?php

class ProducerBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Producer',
                'validAttributes' => [
                    'status',
                    'slug'
                ]
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Store.ProducerBackend.Create'],],
            ['allow', 'actions' => ['delete'], 'roles' => ['Store.ProducerBackend.Delete'],],
            ['allow', 'actions' => ['update'], 'roles' => ['Store.ProducerBackend.Update'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Store.ProducerBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.ProducerBackend.View'],],
            ['deny',],
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
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

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('StoreModule.producer', 'Запись удалена!')
            );

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
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
        $this->render('index', ['model' => $model]);
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
