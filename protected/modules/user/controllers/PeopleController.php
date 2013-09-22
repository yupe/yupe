<?php
class PeopleController extends yupe\components\controllers\FrontController
{
    // Вывод публичной страницы всех пользователей
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User', array('criteria' => array(
            'condition' => 'status = :status',
            'params'    => array(':status' => User::STATUS_ACTIVE),
            'order'     => 'last_visit DESC',
        )));

        $this->render('index', array('dataProvider' => $dataProvider));
    }

    // Вывод публичной страницы пользователя
    public function actionUserInfo($username)
    {
        $user = User::model()->findByAttributes(array("nick_name" => $username));

        if (!$user) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'User was not found'));
        }

        $this->render('userInfo', array('user' => $user));
    }
}