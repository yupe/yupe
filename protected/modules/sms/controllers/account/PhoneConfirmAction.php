<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class PhoneConfirmAction extends CAction
{
    public function run()
    {
        if (($user = Yii::app()->user->getProfile()) === null) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'User not found.')
            );
            Yii::app()->user->logout();
            $this->controller->redirect(
                ['/user/account/login']
            );
        }

        $form = new PhoneConfirmForm();
        $module = Yii::app()->getModule('user');

        if (($data = Yii::app()->getRequest()->getPost('PhoneConfirmForm')) !== null) {
            $form->setAttributes($data);
            if ($form->validate()) {

                $token=$form->token;
                // пытаемся подтвердить телефон
                if (Yii::app()->userManager->verifyPhone($token)) {

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t(
                            'UserModule.user',
                            'You confirmed new phone successfully!'
                        )
                    );

                } else {

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        Yii::t(
                            'UserModule.user',
                            'Phone confirm error! Maybe phone already confirmed or incorrect verification code was used. Try to use another phone'
                        )
                    );
                }

                $this->getController()->redirect(
                    Yii::app()->getUser()->isAuthenticated()
                        ? ['/user/account/profile']
                        : ['/user/account/login']
                );
            }
        }
        $this->controller->render('profilePhoneConfirm', ['model' => $form]);
    }

}
