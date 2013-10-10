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
    /**
     * Запуск action'a:
     *
     * @return nothing
     **/
    public function run()
    {

        /**
         * Если было совершено больше 3х попыток входа
         * в систему, используем сценарий с капчей:
         **/
        $form = new LoginForm(
            Yii::app()->user->getState('badLoginCount', 0) >= 3
                ? 'loginLimit'
                : ''
        );

        if (Yii::app()->request->isPostRequest && !empty($_POST['LoginForm'])) {
            $form->setAttributes($_POST['LoginForm']);

            if ($form->validate()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'You authorized successfully!')
                );

                Yii::log(
                    Yii::t(
                        'UserModule.user', 'User with {email} was logined with IP-address {ip}!', array(
                            '{email}' => $form->email,
                            '{ip}'    => Yii::app()->request->getUserHostAddress(),
                        )
                    ),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );

                $module = Yii::app()->getModule('user');

                $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                    ? array($module->loginAdminSuccess)
                    : array($module->loginSuccess);

                #die('<pre>' . print_r(Yii::app()->user->getReturnUrl(), true) . ' ' . print_r($redirect, true));

                /**
                 * #485 Редиректим запрошенный URL (если такой был задан)
                 * {@link CWebUser getReturnUrl}
                 */
                Yii::app()->user->setState('badLoginCount', null);

                $this->controller->redirect(Yii::app()->user->getReturnUrl($redirect));
            } else {
                Yii::app()->user->setState('badLoginCount', Yii::app()->user->getState('badLoginCount', 0) + 1);

                Yii::log(
                    Yii::t(
                        'user', 'Authorization error with IP-address {ip}! email => {email}, Password => {password}!', array(
                            '{email}'    => $form->email,
                            '{password}' => $form->password,
                            '{ip}'       => Yii::app()->request->getUserHostAddress(),
                        )
                    ),
                    CLogger::LEVEL_ERROR, UserModule::$logCategory
                );
            }
        }
        $this->controller->render($this->id, array('model' => $form));
    }
}