<?php
/**
 * Экшн, отвечающий за регистрацию нового пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/
use yupe\helpers\Url;

class RegistrationAction extends CAction
{
    public function run()
    {
        $module = Yii::app()->getModule('user');

        if (Yii::app()->getUser()->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->getUser()->getReturnUrl());
        }

        if ($module->registrationDisabled) {
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        $form = new RegistrationForm;

        if (($data = Yii::app()->getRequest()->getPost('RegistrationForm')) !== null) {
            
            $form->setAttributes($data);

            if ($form->validate()) {				

				if($user = Yii::app()->userManager->createUser($form)) {
					
				    Yii::app()->user->setFlash(
						yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
						Yii::t('UserModule.user', 'Account was created! Check your email!')
					);
					
					$this->controller->redirect(Url::redirectUrl($module->registrationSuccess));
				}

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error creating account!')
                );
			}
		}

        $this->controller->render('registration', array('model' => $form, 'module' => $module));
    }
}