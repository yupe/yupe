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
	/**
	 * UserTokens используем что-бы не дёргать каждый раз
	 * базу данных:
	 * 
	 * @var UserTokens $model - модель токенов
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
	public function actionCreate()
	{
		$model = new UserTokens;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (($data = Yii::app()->getRequest()->getPost('UserTokens')) !== null) {
            
            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'New record was created!')
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

        if (($data = Yii::app()->getRequest()->getPost('UserTokens')) !== null) {
            
            $model->setAttributes($data);

            if ($model->save()) {
                
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
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

			$this->loadModel($id)->delete();

			Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('UserModule.user', 'Record was removed!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );

        } else {
            throw new CHttpException(
                400,
                Yii::t('UserModule.user', 'Bad request. Please don\'t user similar requests anymore!')
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
		$model = new UserTokens('search');
        
        $model->unsetAttributes(); // clear any default values
        
        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'UserTokens', array()
            )
        );
        
        $this->render('index', array('model' => $model));
	}

	/**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * 
     * @param int $id - record ID
     * 
     * @return UserTokens
     *
     * @throws CHttpException
     */
	public function loadModel($id)
	{
		if ($this->_model === null || $this->_model instanceof UserTokens && $this->_model->id !== $id) {
            
            if (($this->_model = UserTokens::model()->findbyPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t('UserModule.user', 'requested page was not found!')
                );
            }
        }

        return $this->_model;
	}

	/**
     * Performs the AJAX validation.
     * 
     * @param User the model to be validated
     *
     * @return void
     */
	protected function performAjaxValidation($model)
	{

		if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'user-tokens-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
	}
}
