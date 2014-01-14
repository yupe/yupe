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
        $this->render('view', array('model' => $this->loadModel($id)));
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

        $form = new ChangePasswordForm;

        if (($data = Yii::app()->getRequest()->getPost('ChangePasswordForm')) !== null) {
            
            $form->setAttributes($data);

            if ($form->validate() && Yii::app()->userManager->changeUserPassword($model, $form->password)) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Password was changed successfully')
                );

                $this->redirect(array('/user/userBackend/view', 'id' => $model->id));
            }
        }

        $this->render('changepassword', array('model' => $model, 'changePasswordForm' => $form));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new User;

        if (($data = Yii::app()->getRequest()->getPost('User')) !== null) {
            
            $model->setAttributes($data);

            $model->setAttributes(
                array(
                    'hash' => Yii::app()->userManager->hasher->hashPassword(
                        Yii::app()->userManager->hasher->generateRandomPassword()
                    ),
                )
            );

            if ($model->save()) {                

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'New user was created!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
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
                
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Data was updated!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array('update', 'id' => $model->id)
                    )
                );
            }
        }

        $this->render('update', array('model' => $model));
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
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'Record was removed!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
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
                'User', array()
            )
        );
        
        $this->render('index', array('model' => $model));
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
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'User with #{id} was not found', array('{id}' => $id))
                );
                $this->redirect(array('index'));
            } else {
                Yii::app()->ajax->failure(
                    Yii::t('UserModule.user', 'User with #{id} was not found', array('{id}' => $id))
                );
            }
        }

        if ($user->getIsActivated()) {
            if (Yii::app()->getRequest()->getIsAjaxRequest() === false) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'User #{id} is already activated', array('{id}' => $id))
                );
                
                $this->redirect(array('index'));
            } else {
                Yii::app()->ajax->failure(
                    Yii::t('UserModule.user', 'User #{id} is already activated', array('{id}' => $id))
                );
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * 
     * @param int   $id   - record ID
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

        yupe\components\Token::sendEmailVerify(
            $user, '//user/account/needEmailActivationEmail'
        );
    }

    /**
     * Performs the AJAX validation.
     * 
     * @param User the model to be validated
     *
     * @return void
     */
    protected function performAjaxValidation(User $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}