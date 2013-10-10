<?php
/**
 * Контроллер, отвечающий за отображение списка пользователей и профиля пользователя в публичной части сайта
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
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