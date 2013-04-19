<?php
/**
 * File Doc Comment:
 * Файл класса LoginAction, который расширяет возможности стандартного CAction
 *
 * @category YupeControllerActions
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5 (dev)
 * @link     http://yupe.ru
 *
 **/

/**
 * Файл класса LoginAction, который расширяет возможности стандартного CAction
 *
 * @category YupeControllerActions
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5 (dev)
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
        $form = new LoginForm;

        if (Yii::app()->request->isPostRequest && !empty($_POST['LoginForm'])) {
            $form->setAttributes($_POST['LoginForm']);

            if ($form->validate()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('UserModule.user', 'Вы успешно авторизовались!')
                );

                Yii::log(
                    Yii::t('UserModule.user', 'Пользователь {email} авторизовался!', array('{email}' => $form->email)),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );

                $module = Yii::app()->getModule('user');

                $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                    ? array($module->loginAdminSuccess)
                    : array($module->loginSuccess);

                /**
                 * #485 Редиректим запрошенный URL (если такой был задан)
                 * {@link CWebUser getReturnUrl}
                 */
                $this->controller->redirect(Yii::app()->user->getReturnUrl($redirect));
            }
            else
                Yii::log(
                    Yii::t(
                        'user', 'Ошибка авторизации! email => {email}, Password => {password}!', array(
                            '{email}' => $form->email,
                            '{password}' => $form->password
                        )
                    ),
                    CLogger::LEVEL_ERROR, UserModule::$logCategory
                );
        }
        $this->controller->render($this->id, array('model' => $form));
    }
}