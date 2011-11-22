<?php
class DefaultController extends YBackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
                                   'model' => $this->loadModel($id),
                              ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Gallery;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
                                     'model' => $model,
                                ));
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

        if (isset($_POST['Gallery']))
        {
            $model->attributes = $_POST['Gallery'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
                                     'model' => $model,
                                ));
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl']
                                    : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteImage($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            ImageToGallery::model()->findByPk((int)$id)->delete();

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl']
                                    : array('admin'));
            }

        }
        else        
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');        
    }

    public function actionAddImage($galleryId)
    {
        $gallery = $this->loadModel((int)$galleryId);

        $image = new Image;

        if (Yii::app()->request->isPostRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                if ($image->create($_POST['Image']))
                {
                    if ($gallery->addImage($image))                    
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('gallery', 'Фотография добавлена!'));                    

                    $transaction->commit();

                    $this->redirect(array('/gallery/default/view/', 'id' => $gallery->id));
                }

                throw new CDbException(Yii::t('gallery', 'При добавлении изображения произошла ошибка!'));
            }
            catch (Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('gallery', $e->getMessage()));
            }

            $this->redirect(array('/gallery/default/view/', 'id' => $gallery->id));
        }

        $this->render('addImage', array('gallery' => $gallery, 'model' => $image));
    }

    /**
     * Lists all models
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Gallery');

        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Gallery('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Gallery']))
            $model->attributes = $_GET['Gallery'];

        $this->render('admin', array(
                                    'model' => $model,
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Gallery::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'gallery-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}