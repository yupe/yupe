<?php

/**
 * Контроллер, отвечающий за работу с пользователями в панели управления
 *
 * @category YupeControllers
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/
class UserBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['User.UserBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['User.UserBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['User.UserBackend.Create']],
            ['allow', 'actions' => ['update', 'inline', 'sendactivation'], 'roles' => ['User.UserBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['User.UserBackend.Delete']],
            ['allow', 'actions' => ['changepassword'], 'roles' => ['User.UserBackend.Changepassword']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'User',
                'validAttributes' => ['access_level', 'status', 'email_confirm']
            ]
        ];
    }

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Displays a particular model.
     *
     * @param int $id - record ID
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Экшен смены пароля:
     *
     * @param int $id - record ID
     *
     * @return void
     */
    public function actionChangepassword($id)
    {
        $model = $this->loadModel($id);

        $form = new ChangePasswordForm();

        if (($data = Yii::app()->getRequest()->getPost('ChangePasswordForm')) !== null) {

            $form->setAttributes($data);

            if ($form->validate() && Yii::app()->userManager->changeUserPassword($model, $form->password)) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Password was changed successfully')
                );

                $this->redirect(['/user/userBackend/view', 'id' => $model->id]);
            }
        }

        $this->render('changepassword', ['model' => $model, 'changePasswordForm' => $form]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new User();

        if (($data = Yii::app()->getRequest()->getPost('User')) !== null) {

            $model->setAttributes($data);

            $model->setAttributes(
                [
                    'hash' => Yii::app()->userManager->hasher->hashPassword(
                            Yii::app()->userManager->hasher->generateRandomPassword()
                        ),
                ]
            );

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'New user was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id - record ID
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('User')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Data was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id - record ID
     *
     * @return void
     *
     * @throws CHttpException If record not found
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // we only allow deletion via POST request
            if ($this->loadModel($id)->delete()) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Record was removed!')
                );
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'You can\'t make this changes!')
                );
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('UserModule.user', 'Bad request. Please don\'t use similar requests anymore!')
            );
        }
    }

    /**
     * Manages all models.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new User('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'User',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Для отправки письма с активацией:
     *
     * @return void
     */
    public function actionSendactivation($id)
    {
        Yii::app()->getRequest()->getIsAjaxRequest() === true || $this->badRequest();

        if (($user = $this->loadModel($id)) === null) {
            if (Yii::app()->getRequest()->getIsAjaxRequest() === false) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'User with #{id} was not found', ['{id}' => $id])
                );
                $this->redirect(['index']);
            } else {
                Yii::app()->ajax->failure(
                    Yii::t('UserModule.user', 'User with #{id} was not found', ['{id}' => $id])
                );
            }
        }

        if ($user->status == User::STATUS_ACTIVE) {
            if (Yii::app()->getRequest()->getIsAjaxRequest() === false) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'User #{id} is already activated', ['{id}' => $id])
                );

                $this->redirect(['index']);
            } else {
                Yii::app()->ajax->failure(
                    Yii::t('UserModule.user', 'User #{id} is already activated', ['{id}' => $id])
                );
            }
        }

        $tokenStorage = new TokenStorage();

        if (($token = $tokenStorage->createEmailVerifyToken($user))) {
            //@TODO
            Yii::app()->notify->send(
                $user,
                Yii::t(
                    'UserModule.user',
                    'Registration on {site}',
                    ['{site}' => Yii::app()->getModule('yupe')->siteName]
                ),
                '//user/email/needAccountActivationEmail',
                [
                    'token' => $token
                ]
            );

            Yii::app()->ajax->success(Yii::t('UserModule.user', 'Sent!'));
        }

        Yii::app()->ajax->failure();

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param int $id - record ID
     *
     * @return User
     *
     * @throws CHttpException
     */
    public function loadModel($id = null)
    {
        if ($this->_model === null || $this->_model instanceof User && $this->_model->id !== $id) {

            if (($this->_model = User::model()->findbyPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t('UserModule.user', 'requested page was not found!')
                );
            }
        }

        return $this->_model;
    }

    /**
     * Отправить письмо для подтверждения email:
     *
     * @param integer $id - ID пользователя
     *
     * @throws CHttpException
     *
     * @return void
     */
    public function actionVerifySend($id = null)
    {
        Yii::app()->getRequest()->getIsAjaxRequest() === true || $this->badRequest();

        if ($id === null || ($user = $this->loadModel($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('UserModule.user', 'requested page was not found!')
            );
        } elseif ($user->email_confirm) {
            return $this->badRequest();
        }

        $tokenStorage = new TokenStorage();

        if (($token = $tokenStorage->createEmailVerifyToken($user))) {
            Yii::app()->notify->send(
                $user,
                Yii::t('UserModule.user', 'Email verification'),
                '//user/email/needEmailActivationEmail',
                [
                    'token' => $token
                ]
            );

            Yii::app()->ajax->success(Yii::t('UserModule.user', 'Sent!'));
        }

        Yii::app()->ajax->failure();
    }
}
