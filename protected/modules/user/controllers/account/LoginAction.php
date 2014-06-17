<?php

/**
 * Экшн, отвечающий за авторизацию пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/
class LoginAction extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->getUser()->getReturnUrl());
        }

        /**
         * Если было совершено больше 3х попыток входа
         * в систему, используем сценарий с капчей:
         **/

        $badLoginCount = Yii::app()->authenticationManager->getBadLoginCount(Yii::app()->getUser());

        $module = Yii::app()->getModule('user');

        $scenario = $badLoginCount > (int)$module->badLoginCount ? LoginForm::LOGIN_LIMIT_SCENARIO : '';

        $form = new LoginForm($scenario);

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['LoginForm'])) {

            $form->setAttributes(Yii::app()->getRequest()->getPost('LoginForm'));

            if ($form->validate() && Yii::app()->authenticationManager->login(
                    $form,
                    Yii::app()->getUser(),
                    Yii::app()->getRequest()
                )
            ) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'You authorized successfully!')
                );

                $module->onSuccessLogin(
                    new CModelEvent($this->controller, array('loginForm' => $form))
                );

                $redirect = Yii::app()->getUser()->getReturnUrl();

                if (!$redirect) {
                    if (Yii::app()->getUser()->isSuperUser() && $module->loginAdminSuccess) {
                        $redirect = $module->loginAdminSuccess;
                    } else {
                        $redirect = empty($module->loginSuccess) ? Yii::app()->getBaseUrl(
                        ) : $module->loginSuccess;
                    }
                }

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->getUser(), 0);

                $this->controller->redirect(Yii::app()->createAbsoluteUrl($redirect));

            } else {

                $form->addError('email', Yii::t('UserModule.user', 'Email or password was typed wrong!'));

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->getUser(), $badLoginCount + 1);

                $module->onErrorLogin(
                    new CModelEvent($this->controller, array('loginForm' => $form))
                );
            }
        }

        $this->controller->render($this->id, array('model' => $form));
    }
}