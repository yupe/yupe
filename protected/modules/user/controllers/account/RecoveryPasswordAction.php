<?php
/**
 * Экшн, отвечающий за процедуру восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/

use yupe\components\WebModule;

class RecoveryPasswordAction extends CAction
{
    /**
     * Стартуем экшен сброса пароля
     * @param  string $token - токен-сброса пароля
     * @throws CHttpException
     */
    public function run($token)
    {
        $module = Yii::app()->getModule('user');

        // Если запрещено восстановление
        if ($module->recoveryDisabled) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        //Проверка токена
        $tokenModel = Yii::app()->userManager->tokenStorage->get($token, UserToken::TYPE_CHANGE_PASSWORD);

        if (null === $tokenModel) {
            throw new CHttpException(404);
        }

        // Если включено автоматическое восстановление пароля
        if ((int)$module->autoRecoveryPassword === WebModule::CHOICE_YES) {

            if (Yii::app()->userManager->activatePassword($token)) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'New password was sent to your email')
                );

                $this->getController()->redirect(['/user/account/login']);

            } else {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error when changing password!')
                );

                $this->getController()->redirect(['/user/account/recovery']);
            }
        }

        // Форма смены пароля:
        $changePasswordForm = new ChangePasswordForm();

        // Получаем данные POST если таковые имеются:
        if (($data = Yii::app()->getRequest()->getPost('ChangePasswordForm')) !== null) {

            $changePasswordForm->setAttributes($data);

            // Проводим валидацию формы:
            if ($changePasswordForm->validate() && Yii::app()->userManager->activatePassword(
                    $token,
                    $changePasswordForm->password
                )
            ) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('UserModule.user', 'Password recover successfully')
                );

                $this->getController()->redirect(['/user/account/login']);
            }
        }

        // Отрисовываем форму:
        $this->getController()->render('changePassword', ['model' => $changePasswordForm]);
    }
}
