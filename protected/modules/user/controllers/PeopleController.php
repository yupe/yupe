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
class PeopleController extends \yupe\components\controllers\FrontController
{
    // Вывод публичной страницы всех пользователей
    public function actionIndex()
    {
        $users = new User('search');
        $users->unsetAttributes();
        $users->status = User::STATUS_ACTIVE;

        if (isset($_GET['User']['nick_name'])) {
            $users->nick_name = CHtml::encode($_GET['User']['nick_name']);
        }

        $this->render('index', ['users' => $users, 'provider' => $users->search((int)$this->module->usersPerPage)]);
    }

    // Вывод публичной страницы пользователя
    public function actionUserInfo($username)
    {
        $user = User::model()->active()->findByAttributes(["nick_name" => $username]);

        if (null === $user) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'User was not found'));
        }

        $this->render('userInfo', ['user' => $user]);
    }
}
