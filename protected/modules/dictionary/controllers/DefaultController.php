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
        $model = new DictionaryGroup;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DictionaryGroup']))
        {
            $model->attributes = $_POST['DictionaryGroup'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('DictionaryModule.dictionary', 'Запись добавлена!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DictionaryGroup']))
        {
            $model->attributes = $_POST['DictionaryGroup'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('DictionaryModule.dictionary', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('DictionaryModule.dictionary', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new DictionaryGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DictionaryGroup']))
            $model->attributes = $_GET['DictionaryGroup'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = DictionaryGroup::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('DictionaryModule.dictionary', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dictionary-group-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}