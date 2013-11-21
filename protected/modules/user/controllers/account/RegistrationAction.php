<?php
/**
 * Экшн, отвечающий за регистрацию нового пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/

use yupe\components\WebModule;

class RegistrationAction extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(Yii::app()->user->returnUrl);
        }

        $module = Yii::app()->getModule('user');

        if ($module->registrationDisabled) {
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }

        $form = new RegistrationForm;

        $event = new CModelEvent($form);

        $module->onBeginRegistration($event);

        if (($data = Yii::app()->getRequest()->getPost('RegistrationForm')) !== null) {
            
            $form->setAttributes($data);

            if ($form->validate()) {				

				if(Yii::app()->userManager->createUser($form)) {
					
				    Yii::app()->user->setFlash(
						YFlashMessages::SUCCESS_MESSAGE,
						Yii::t('UserModule.user', 'Account was created! Check your email!')
					);
					
					$this->controller->redirect(array($module->registrationSuccess));
				}

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('UserModule.user', 'Error creating account!')
                );
			}
		}               

        $this->controller->render('registration', array('model' => $form, 'module' => $module));
    }
}