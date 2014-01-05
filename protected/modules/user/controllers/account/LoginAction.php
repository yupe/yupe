<?php
/**
 * Экшн, отвечающий за авторизацию пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class LoginAction extends CAction
{   
    public function run()
    {
        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        /**
         * Если было совершено больше 3х попыток входа
         * в систему, используем сценарий с капчей:
         **/

        $badLoginCount = Yii::app()->authenticationManager->getBadLoginCount(Yii::app()->user);

        //@TODO 3 вынести в настройки модуля
        $scenario = $badLoginCount > 3 ? 'loginLimit' : '';

        $form = new LoginForm($scenario);

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['LoginForm'])) {

            $form->setAttributes(Yii::app()->request->getPost('LoginForm'));

            if ($form->validate() && Yii::app()->authenticationManager->login($form, Yii::app()->user, Yii::app()->request)) {

                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'You authorized successfully!')
                );

                $module = Yii::app()->getModule('user');

                $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                    ? array($module->loginAdminSuccess)
                    : empty($module->loginSuccess) ? Yii::app()->baseUrl : array($module->loginSuccess);

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->user, 0);                

                $this->controller->redirect($redirect);

            } else {

                $form->addError('hash', Yii::t('UserModule.user', 'Email or password was typed wrong!'));

                Yii::app()->authenticationManager->setBadLoginCount(Yii::app()->user, $badLoginCount + 1);

            }
        }

        $this->controller->render($this->id, array('model' => $form));
    }
}