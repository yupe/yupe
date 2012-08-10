<?php
class DefaultController extends YBackController
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    public function actionChangepassword($id)
    {
        $model = $this->loadModel();

        $form = new ChangePasswordForm;

        if(Yii::app()->request->isPostRequest && !empty($_POST['ChangePasswordForm']))
        {
            $form->setAttributes($_POST['ChangePasswordForm']);

            if($form->validate() && $model->changePassword($form->password))
            {
                $model->changePassword($form->password);

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Пароль успешно изменен!'));

                $this->redirect(array('/user/default/view/','id' => $model->id ));
            }
        }

        $this->render('changepassword',array('model' => $model, 'changePasswordForm' => $form));
    }

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view', array('model' => $this->loadModel()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new User;

        if (Yii::app()->request->isPostRequest && !empty($_POST['User']))
        {
            $model->setAttributes($_POST['User']);

            $model->setAttributes(array(
                'salt'              => $model->generateSalt(),
                'password'          => $model->hashPassword($model->password, $model->salt),
                'registration_ip'   => Yii::app()->request->userHostAddress,
                'activation_ip'     => Yii::app()->request->userHostAddress,
                'registration_date' => new CDbExpression("NOW()"),
            ));
            
            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Новый пользователь добавлен!'));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model,));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();

        if (Yii::app()->request->isPostRequest && !empty($_POST['User']))
        {
            $model->setAttributes($_POST['User']);

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Данные обновлены!'));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model,));
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

        $this->render('index', array('dataProvider' => $dataProvider));
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

        $this->render('admin', array('model' => $model));
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