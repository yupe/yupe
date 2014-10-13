<?php

/**
 * Экшн, отвечающий за смену пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.8
 * @link     http://yupe.ru
 *
 **/
class ProfilePasswordAction extends CAction
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
                array('/user/account/login')
            );
        }
        $form = new ProfilePasswordForm();

        if (($data = Yii::app()->getRequest()->getPost('ProfilePasswordForm')) !== null) {
            $form->setAttributes($data);
            if ($form->validate()) {
                $user->hash = Yii::app()->userManager->hasher->hashPassword($form->password);
                if ($user->save()) {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('UserModule.user', 'Your password was changed successfully.')
                    );
                    $this->controller->redirect(array('/user/account/profile'));
                }
            }
        }
        $this->controller->render('profilePassword', array('model' => $form));
    }
}
