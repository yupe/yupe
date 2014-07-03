<?php
/**
 * Экшн, отвечающий за запрос восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/

use yupe\widgets\YFlashMessages;

class RecoveryAction extends CAction
{
    public function run()
    {
        // Незачем выполнять последующие действия
        // для авторизованного пользователя:
        if (Yii::app()->getUser()->isAuthenticated()) {
            $this->controller->redirect(
                Yii::app()->getUser()->getReturnUrl()
            );
        }

        $module = Yii::app()->getModule('user');

        // Если восстановление отключено - ошбочка ;)
        if ($module->recoveryDisabled) {
            throw new CHttpException(
                404,
                Yii::t('UserModule.user', 'requested page was not found!')
            );
        }

        // Новая форма восстановления пароля:
        $form = new RecoveryForm;

        if (($data = Yii::app()->getRequest()->getPost('RecoveryForm')) !== null) {

            $form->setAttributes($data);

            if ($form->validate()) {

                if (Yii::app()->userManager->passwordRecovery($form->email)) {

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t(
                            'UserModule.user',
                            'Letter with password recovery instructions was sent on email which you choose during register'
                        )
                    );

                    $this->controller->redirect(array('/user/account/login'));
                }

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Password recovery error.')
                );

                $this->controller->redirect(array('/user/account/recovery'));
            }
        }

        $this->controller->render('recovery', array('model' => $form));
    }
}