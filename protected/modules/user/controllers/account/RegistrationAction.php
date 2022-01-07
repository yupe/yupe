<?php
/**
 * Экшн, отвечающий за регистрацию нового пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     https://yupe.ru
 *
 **/
use yupe\helpers\Url;

/**
 * Class RegistrationAction
 */
class RegistrationAction extends CAction
{
    /**
     * @throws CHttpException
     */
    public function run()
    {
        if (false === Yii::app()->getUser()->getIsGuest()) {
            $this->getController()->redirect(\yupe\helpers\Url::redirectUrl(
                Yii::app()->getModule('user')->loginSuccess
            ));
        }

        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled) {
            throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        $form = new RegistrationForm;

        if (($data = Yii::app()->getRequest()->getPost('RegistrationForm')) !== null) {

            $form->setAttributes($data);

            if ($form->validate()) {

                if ($user = Yii::app()->userManager->createUser($form)) {

                    if (!$module->emailAccountVerification) {
                        $this->autoLoginUser($form);
                    }

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('UserModule.user', 'Account was created! Check your email!')
                    );

                    $this->getController()->redirect(Url::redirectUrl($module->registrationSuccess));
                }

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error creating account!')
                );
            }
        }

        $this->getController()->render('registration', ['model' => $form, 'module' => $module]);
    }

    /**
     * Auto-login user.
     *
     * @param RegistrationForm $form
     * @return bool
     */
    private function autoLoginUser(RegistrationForm $form)
    {
        $loginForm = new LoginForm();
        $loginForm->remember_me = true;
        $loginForm->email = $form->email;
        $loginForm->password = $form->password;

        return Yii::app()->authenticationManager->login(
            $loginForm,
            Yii::app()->getUser(),
            Yii::app()->getRequest()
        );
    }
}