<?php

class DefaultController extends YBackController
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;
    
    public function actionPwdChange($id) {
	$model = $this->loadModel();
	
	if(isset($_POST['User'], $_POST['User']['password']) && $model->newPassword($_POST['User']['password']))
	{
	    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Пароль успешно изменен!'));
	    $this->redirect(array('/user/default/admin'));
	}
	
	if(Yii::app()->request->isAjaxRequest)
	{
	    $module = Yii::app()->getModule('yupe');
	    $this->layout = $module->emptyLayout;
	}
	
	$model->password = '';
	
	$this->render('pwdChange', array(
	    'model' => $model,
	));
    }

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
        $model = new User();

        if (isset($_POST['User']))
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                $model->setAttributes($_POST['User']);
                $model->salt = Registration::model()->generateSalt();
                $model->password = Registration::model()->hashPassword($model->password, $model->salt);
                $model->registration_ip = Yii::app()->request->userHostAddress;

                if ($model->save())
                {                    
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Новый пользователь добавлен!'));
					
                    $this->redirect(array('view', 'id' => $model->id));                    
                }

            }
            catch (CDbException $e)
            {
                $transaction->rollback();
                Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, UserModule::$logCategory);
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, $e->getMessage());
                $this->redirect(array('create'));
            }
        }

        $this->render('create', array(
                                     'model' => $model,
                                ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();

        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Данные обновлены!'));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
                                     'model' => $model,
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
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User');

        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
                                    'model' => $model,
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @return User
     */
    public function loadModel()
    {
        if ($this->_model === null)
        {
            if (isset($_GET['id']))
                $this->_model = User::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
