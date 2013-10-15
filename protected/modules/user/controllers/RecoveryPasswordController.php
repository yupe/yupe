<?php
/**
 * Контроллер, отвечающий за работу с запросами на восстановление пароля в панели управления
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryPasswordController extends yupe\components\controllers\BackController
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('UserModule.user', 'Bad request. Please don\'t user similar requests anymore!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new RecoveryPassword('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['RecoveryPassword']))
            $model->attributes = $_GET['RecoveryPassword'];

        $this->render('index', array('model' => $model));
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
                $this->_model = RecoveryPassword::model()->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'recovery-password-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}