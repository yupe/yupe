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
        $module = Yii::app()->getModule('user');

        // Если восстановление отключено - ошбочка ;)
        if ($module->recoveryDisabled) {
            throw new CHttpException(
                404,
                Yii::t('UserModule.user', 'requested page was not found!')
            );
        }

        // Новая форма восстановления пароля:
        $form = new RecoveryForm();

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

                    $this->getController()->redirect(['/user/account/login']);
                }

                Yii::app()->getUser()->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Password recovery error.')
                );

                $this->getController()->redirect(['/user/account/recovery']);
            }
        }

        $this->getController()->render('recovery', ['model' => $form]);
    }
}
