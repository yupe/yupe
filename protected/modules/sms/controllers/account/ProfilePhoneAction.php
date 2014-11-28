<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class ProfilePhoneAction extends CAction
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

        $form = new ProfilePhoneForm();
        $module = Yii::app()->getModule('user');

        if (($data = Yii::app()->getRequest()->getPost('ProfilePhoneForm')) !== null) {
            $form->setAttributes($data);
            if ($form->validate()) {
                $oldPhone = $user->phone;

                // Если включена верификация при смене почты:
                if ($module->phoneAccountVerification && ($oldPhone != $form->phone)) {
                    // Вернуть старый phone на время проверки
                    $user->phone = $oldPhone;

                    if (Yii::app()->userManager->changeUserPhone($user, $form->phone)) {
                        Yii::app()->user->setFlash(
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t(
                                'UserModule.user',
                                'You need to confirm your phone. Please check the sms message!'
                            )
                        );
                    }
                } else {
                    $user->phone = $form->phone;
                    $user->save();
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('UserModule.user', 'Phone was updated.')
                    );
                }
                $this->controller->redirect(['/user/account/profile']);
            }
        }
        $this->controller->render('profilePhone', ['model' => $form]);
    }
}
