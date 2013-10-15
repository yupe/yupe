<?php
/**
 * Экшн, отвечающий за процедуру восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryPasswordAction extends CAction
{
    // сброс пароля
    public function run($key)
    {
        $module = Yii::app()->getModule('user');

        if ($module->recoveryDisabled)
        {
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        }
        else
        {
			if (Yii::app()->user->isAuthenticated()) {
				$this->controller->redirect(Yii::app()->user->returnUrl);
            }

			$recovery = RecoveryPassword::model()->with('user')->find('code = :code', array(':code' => $key));

			if (!$recovery)
			{
				Yii::log(
					Yii::t('UserModule.user', 'Recovery password key {code} was not found!', array('{code}' => $key)),
					CLogger::LEVEL_ERROR, UserModule::$logCategory
				);
				Yii::app()->user->setFlash(
					YFlashMessages::ERROR_MESSAGE,
					Yii::t('UserModule.user', 'Recovery password key was not found! Please try one more!')
				);

				$this->controller->redirect(array('/user/account/recovery'));
			}

			// автоматическое восстановление пароля
			if ($module->autoRecoveryPassword)
			{
				$newPassword = User::model()->generateRandomPassword();
				$recovery->user->password = User::model()->hashPassword($newPassword, $recovery->user->salt);
				$transaction = Yii::app()->db->beginTransaction();
				try
				{
					if ($recovery->user->save())
					{
						if (RecoveryPassword::model()->deleteAll('user_id = :user_id', array(':user_id' => $recovery->user->id)))
						{
							$transaction->commit();
							$emailBody = $this->controller->renderPartial('passwordAutoRecoverySuccessEmail', array('model' => $recovery->user, 'password' => $newPassword), true);

							Yii::app()->mail->send(
								$module->notifyEmailFrom,
								$recovery->user->email,
								Yii::t('UserModule.user', 'Password recover successfully'),
								$emailBody
							);
							Yii::app()->user->setFlash(
								YFlashMessages::SUCCESS_MESSAGE,
								Yii::t('UserModule.user', 'New password was sent to your email')
							);
							Yii::log(
								Yii::t('UserModule.user', 'Password recover successfully'),
								CLogger::LEVEL_ERROR, UserModule::$logCategory
							);

							$this->controller->redirect(array('/user/account/login'));
						}
					}
				}
				catch (CDbException $e)
				{
					$transaction->rollback();

					Yii::app()->user->setFlash(
						YFlashMessages::ERROR_MESSAGE,
						Yii::t('UserModule.user', 'Error when changing password!')
					);
					Yii::log(
						Yii::t('UserModule.user', 'Error when change password automaticly! {error}', array('{error}' => $e->getMessage())),
						CLogger::LEVEL_ERROR, UserModule::$logCategory
					);
					$this->controller->redirect(array('/user/account/recovery'));
				}
			}

			// выбор своего пароля
			$changePasswordForm = new ChangePasswordForm;

			// если отправили фому с новым паролем
			if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['ChangePasswordForm']))
			{
				$changePasswordForm->setAttributes($_POST['ChangePasswordForm']);

				if ($changePasswordForm->validate())
				{
					$transaction = Yii::app()->db->beginTransaction();
					try
					{
						// смена пароля пользователя
						$recovery->user->password = User::model()->hashPassword($changePasswordForm->password, $recovery->user->salt);
						// удалить все запросы на восстановление для данного пользователя
						if ($recovery->user->save())
						{
							if (RecoveryPassword::model()->deleteAll('user_id = :user_id', array(':user_id' => $recovery->user->id)))
							{
								$transaction->commit();

								Yii::app()->user->setFlash(
									YFlashMessages::SUCCESS_MESSAGE,
									Yii::t('UserModule.user', 'Password was changed')
								);
								Yii::log(
									Yii::t('UserModule.user', 'Password for {user} user was changed successfully', array('{user}' => $recovery->user->id)),
									CLogger::LEVEL_INFO, UserModule::$logCategory
								);

								$emailBody = $this->controller->renderPartial('passwordRecoverySuccessEmail', array('model' => $recovery->user), true);
								Yii::app()->mail->send(
									$module->notifyEmailFrom,
									$recovery->user->email,
									Yii::t('UserModule.user', 'Password recover successfully'),
									$emailBody
								);
								$this->controller->redirect(array('/user/account/login'));
							}
						}
					}
					catch (CDbException $e)
					{
						$transaction->rollback();

						Yii::app()->user->setFlash(
							YFlashMessages::ERROR_MESSAGE,
							Yii::t('UserModule.user', 'Error when changing password!')
						);
						Yii::log(
							Yii::t('Error when changing password!', array('{error}' => $e->getMessage())),
							CLogger::LEVEL_ERROR, UserModule::$logCategory
						);
						$this->controller->redirect(array('/user/account/recovery'));
					}
				}
			}
			$this->controller->render('changePassword', array('model' => $changePasswordForm));
        }
    }
}