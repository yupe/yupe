<?php
class DefaultController extends YBackController
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;


    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view', array(
                                   'model' => $this->loadModel(),
                              ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Page;

        if (isset($_POST['Page']))
        {
            $model->attributes = $_POST['Page'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Страница добавлена!'));

                if (isset($_POST['saveAndClose']))                
                    $this->redirect(array('admin'));                

                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
                                     'model' => $model,
                                     'pages' => Page::model()->getAllPagesList()
                                ));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();

        if (isset($_POST['Page']))
        {
            $model->attributes = $_POST['Page'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Страница обновлена!'));

                if (isset($_POST['saveAndClose']))                
                    $this->redirect(array('admin'));                

                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('update', array(
                                     'model' => $model,
                                     'pages' => Page::model()->getAllPagesList($model->id)
                                ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new YPageNotFoundException('Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Page');
        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Page('search');

        if (isset($_GET['Page']))        
            $model->attributes = $_GET['Page'];        

        $this->render('admin', array(
                                    'model' => $model,
                                    'pages' => Page::model()->getAllPagesList()
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null)
        {
            if (isset($_GET['id']))            
                $this->_model = Page::model()->with('author', 'changeAuthor')->findbyPk($_GET['id']);
            
            if ($this->_model === null)            
                throw new YPageNotFoundException('The requested page does not exist.');
        }
        
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}