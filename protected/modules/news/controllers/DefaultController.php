<?php

class DefaultController extends YBackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new News;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && isset($_POST['News']))
        {
            $model->setAttributes(Yii::app()->request->getPost('News'));

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('NewsModule.news', 'Новость добавлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->date = date('d.m.Y');
        $model->lang = Yii::app()->language;
        $this->render('create', array('model' => $model, 'languages' => $this->yupe->getLanguagesList()));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param null $alias
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(null === $model){
            throw new CHttpException(404);
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['News']))
        {
            $model->setAttributes(Yii::app()->request->getPost('News'));

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('NewsModule.news', 'Новость обновлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update',array('model' => $model, 'languages' => $this->yupe->getLanguagesList()));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param null $alias
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     * @return void
     */
    public function actionDelete($alias = null, $id = null)
    {
        if (Yii::app()->request->isPostRequest)
        {
            if ($alias)
            {
                if (!($model = News::model()->findAllByAttributes(array('alias' => $alias))))
                    throw new CHttpException(404, Yii::t('NewsModule.news', 'Новость не нейдена'));
                $model->delete();
            }
            else
            {
                $model = $this->loadModel($id);
                if ($model->lang != Yii::app()->sourceLanguage)
                    $model->scenario = 'altlang';
                $model->delete();
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('NewsModule.news', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new News('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = News::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('catalog', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}