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
        $this->render('view', array('model' => $this->loadModel()));
    }

    public function actionChangepassword()
    {
        $model = $this->loadModel();

        $form = new ChangePasswordForm;

        if (Yii::app()->request->isPostRequest && !empty($_POST['ChangePasswordForm']))
        {
            $form->setAttributes($_POST['ChangePasswordForm']);

            if ($form->validate() && $model->changePassword($form->password))
            {
                $model->changePassword($form->password);

                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('UserModule.user', 'Пароль успешно изменен!')
                );
                $this->redirect(array('/user/default/view', 'id' => $model->id));
            }
        }
        $this->render('changepassword', array('model' => $model, 'changePasswordForm' => $form));
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
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('UserModule.user', 'Новый пользователь добавлен!')
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
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();

        if (Yii::app()->request->isPostRequest && !empty($_POST['User']))
        {
            $model->setAttributes($_POST['User']);

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('UserModule.user', 'Данные обновлены!')
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('UserModule.user', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new User('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Для отправки письма с активацией:
     *
     * @return void
     */
    public function actionSendactivation($id)
    {
        if (($user = User::model()->findbyPk($id)) === null) {
            if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest) {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Пользователь #{id} не найден!', array('{id}' => $id))
                );
                $this->redirect(array('index'));
            } else
                Yii::app()->ajax->failure(
                    Yii::t('UserModule.user', 'Пользователь #{id} не найден!', array('{id}' => $id))
                );
        }

        // отправка email с просьбой активировать аккаунт
        $mailBody = $this->renderPartial('needAccountActivationEmail', array('model' => $user), true);
        
        Yii::app()->mail->send(
            $this->module->notifyEmailFrom,
            $user->email,
            Yii::t('UserModule.user', 'Регистрация на сайте {site} !', array('{site}' => Yii::app()->name)),
            $mailBody
        );

        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest) {
            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('UserModule.user', 'Письмо с активацией отправлено пользователю #{id}!', array('{id}' => $id))
            );
            $this->redirect(array('index'));
        } else
            Yii::app()->ajax->success(
                Yii::t('UserModule.user', 'Письмо с активацией отправлено пользователю #{id}!', array('{id}' => $id))
            );
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
                throw new CHttpException(404, Yii::t('UserModule.user', 'Запрошенная страница не найдена!'));
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