<?php

class ProducerBackendController extends yupe\components\controllers\BackController
{

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }


    public function actionCreate()
    {
        $model = new Producer();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Producer']))
        {
            $model->attributes = $_POST['Producer'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.producer', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type']))
                {
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else
                {
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

        if (isset($_POST['Producer']))
        {
            $model->attributes = $_POST['Producer'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.producer', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type']))
                {
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else
                {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.producer', 'Запись удалена!')
            );

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
        {
            throw new CHttpException(400, Yii::t('ShopModule.producer', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
        }
    }


    public function actionIndex()
    {
        $model = new Producer('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Producer']))
            $model->attributes = $_GET['Producer'];
        $this->render('index', array('model' => $model));
    }


    public function loadModel($id)
    {
        $model = Producer::model()->findByPk($id);
        if ($model === null)
        {
            throw new CHttpException(404, Yii::t('ShopModule.producer', 'Запрошенная страница не найдена.'));
        }
        return $model;
    }


    protected function performAjaxValidation(Producer $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'producer-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
