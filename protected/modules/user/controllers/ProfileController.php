<?php

/**
 * Контроллер, отвечающий за просмотр профиля, смену почты и пароля.
 * То есть за действия авторизованного пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class ProfileController extends \yupe\components\controllers\FrontController
{
    public $user = null;

    public function filters()
    {
        return [
            ['yupe\filters\YFrontAccessControl'],
        ];
    }

    public function beforeAction($action)
    {
        $this->user = Yii::app()->getUser()->getProfile();

        if ($this->user === null) {

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'User not found.')
            );

            Yii::app()->getUser()->logout();

            $this->redirect(
                ['/user/account/login']
            );
        }

        return true;
    }

    public function actions()
    {
        return [
            'profile' => [
                'class' => 'application.modules.user.controllers.profile.ProfileAction'
            ],
            'password' => [
                'class' => 'application.modules.user.controllers.profile.PasswordAction'
            ],
            'email' => [
                'class' => 'application.modules.user.controllers.profile.EmailAction'
            ],
        ];
    }
}
