<?php

/**
 * Контроллер, отвечающий за работу с токенами пользователей в панели управления
 * токены на восстановление пароля, активации пользователя
 *
 * @category YupeControllers
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/
class TokensBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('delete'), 'roles' => array('User.TokensBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('User.TokensBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('User.TokensBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('User.TokensBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('User.TokensBackend.View')),
            array('deny')
        );
    }

    /**
     * UserToken используем что-бы не дёргать каждый раз
     * базу данных:
     *
     * @var UserToken $model - модель токенов
     */
    private $_model = null;

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

        if (($data = Yii::app()->getRequest()->getPost('UserToken')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Data was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('update', 'id' => $model->id)
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

            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'Record was removed!')
            );

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
        $model = new UserToken('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'UserToken',
                array()
            )
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Скомпрометировать токен (делаем его недействительным):
     *
     * @param integer $id - ID записи
     *
     * @return void
     *
     * @throws CHttpException If isPostRequest === false
     */
    public function actionCompromise($id)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getQuery(
                'ajax'
            ) === 'user-tokens-grid'
        ) {

            $this->loadModel($id)->compromise();

            return $this->actionIndex();

        } else {
            throw new CHttpException(
                400,
                Yii::t('UserModule.user', 'Bad request. Please don\'t use similar requests anymore!')
            );
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param int $id - record ID
     *
     * @return UserToken
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if ($this->_model === null || $this->_model instanceof UserToken && $this->_model->id !== $id) {

            if (($this->_model = UserToken::model()->findbyPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t('UserModule.user', 'requested page was not found!')
                );
            }
        }

        return $this->_model;
    }

    /**
     * Данные для ajax-ссылки на удаление записи:
     *
     * @param UserToken $model - модель токена
     *
     * @return array
     */
    public function getDeleteLink(UserToken $model)
    {
        return array(
            'url'        => array('delete', 'id' => $model->id),
            'csrf'       => true,
            'data'       => array(
                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
            ),
            'type'       => 'POST',
            'confirm'    => Yii::t('UserModule.user', 'Are you sure you want to delete this token?'),
            'beforeSend' => "function () {
                if (!confirm(this.confirm)) return false;
                return true;
            }",
            'always'     => "function () {
                window.location.href = '" . $this->createUrl('index') . "';
            }",
        );
    }
}
