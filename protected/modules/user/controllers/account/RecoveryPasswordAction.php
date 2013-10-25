<?php
/**
 * Экшн, отвечающий за процедуру восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/
class RecoveryPasswordAction extends CAction
{
	/**
	 * Попытка выполнить обновление пароля и сообщить
	 * пользователю результат:
	 * 
	 * @param User   $user       - пользователь
	 * @param string $password   - новый пароль
	 * @param mixed  $successUrl - куда отправляем пользователя
	 * 
	 * @return void
	 */
	protected function tryUpdate($user, $password, $successUrl = null)
	{
		// Получаем модуль (для сокращения записи):
		$module = Yii::app()->getModule('user');

		// начинаем тразакцию:
		$transaction = Yii::app()->getDb()->beginTransaction();
		
		try {
			
			// Сохраняем изменения и инвалидируем токен:
			if ($user->update((array) 'password') && $user->recovery->compromise()) {
				
				// Сообщаем пользователю:
				Yii::app()->user->setFlash(
					YFlashMessages::SUCCESS_MESSAGE,
					$module->autoRecoveryPassword === "1"
						? Yii::t(
                            'UserModule.user',
                            'Letter with password recovery instructions was sent on email which you choose during register'
                        )
						: Yii::t('UserModule.user', 'Password was changed')
				);

				// Пишем в лог-файл:
				Yii::log(
					Yii::t(
						'UserModule.user',
						'Password for {user} user was changed successfully',
						array('{user}' => $user->id)
					),
					CLogger::LEVEL_INFO, UserModule::$logCategory
				);

				// Формируем тело письма:
				$emailBody = $module->autoRecoveryPassword === "1"
					// При автоматическом:
					? $this->controller->renderPartial(
						'passwordAutoRecoverySuccessEmail', array(
							'model'    => $user,
							'password' => $password,
						), true
					)
					// При простом восстановлении:
					: $this->controller->renderPartial(
						'passwordRecoverySuccessEmail', array(
							'model' => $user
						), true
					);
				
				// Отправляем письмо пользователю:
				Yii::app()->mail->send(
					$module->notifyEmailFrom,
					$user->email,
					Yii::t('UserModule.user', 'Password recover successfully'),
					$emailBody
				);

				// Коммитим правки:
				$transaction->commit();
				
				// Выполняем переадресацию:
				$this->controller->redirect((array) $successUrl);
			} else {
				// Если не удалось сохранить модель пользователя
				// или инвалидировать токен - создаём ексепшен:
				throw new Exception(
					'Error when changing password!'
					. '<pre>'
					. print_r($user->getErrors(), true)
					. print_r($user->recovery->getErrors(), true)
					. '</pre>'
				);
			}

		// Ловим все исключения:
		} catch (Exception $e) {

			// Откатываем правки:
			$transaction->rollback();

			// Сообщаем пользователю:
			Yii::app()->user->setFlash(
				YFlashMessages::ERROR_MESSAGE,
				Yii::t('UserModule.user', 'Error when changing password!')
			);

			// Пишем в лог:
			Yii::log(
				Yii::t('UserModule.user', 'Error when changing password!')
				. "Error: " . $e->getMessage(),
				CLogger::LEVEL_ERROR, UserModule::$logCategory
			);

			// Перенаправляем по назначению:
			$this->controller->redirect(array('/user/account/recovery'));
		}
	}

    /**
     * Стартуем экшен сброса пароля:
     * 
     * @param string $token - токен-сброса пароля
     * 
     * @return [type]      [description]
     */
    public function run($token)
    {
        $module = Yii::app()->getModule('user');

        // Если запрещено восстановление - печалька ;)
        if ($module->recoveryDisabled) {
        
        	throw new CHttpException(404, Yii::t('UserModule.user', 'requested page was not found!'));
        
        // Если пользователь авторизирован - незачем идти дальше:
        } elseif (Yii::app()->user->isAuthenticated()) {

        	$this->controller->redirect(Yii::app()->user->returnUrl);

        // Выполняем поиск, если токен не найден - печалька :'(
		} elseif (($user = User::model()->findRecovery($token)) === null) {
			
			// Записываем событие в лог-файл:
			Yii::log(
				Yii::t(
					'UserModule.user',
					'Recovery password key {code} was not found!',
					array(
						'{code}' => $token
					)
				),
				CLogger::LEVEL_ERROR, UserModule::$logCategory
			);
			
			// Сообщаем о проблеме пользователю:
			Yii::app()->user->setFlash(
				YFlashMessages::ERROR_MESSAGE,
				Yii::t('UserModule.user', 'Recovery password key was not found! Please try one more!')
			);

			// Перенаправляем на необходимую страницу:
			$this->controller->redirect(array('/user/account/recovery'));
		}

		// Если включено автоматическое восстановление пароля:
		if ($module->autoRecoveryPassword === "1") {
			
			// Генерируем новый пароль:
			$user->password = User::hashPassword(
				$newPassword = User::generateRandomPassword(
					$module->minPasswordLength
				),
				$user->salt
			);

			// Пытаемся обновить данные:
			$this->tryUpdate($user, $newPassword, '/user/account/login');
		}

		// Форма смены пароля:
		$changePasswordForm = new ChangePasswordForm;

		// Получаем данные POST если таковые имеются:
		if (($data = Yii::app()->getRequest()->getPost('ChangePasswordForm')) !== null) {
			
			// Заполняем поля формы POST-данными:
			$changePasswordForm->setAttributes($data);

			// Проводим валидацию формы:
			if ($changePasswordForm->validate()) {

				// смена пароля пользователя
				$user->password = User::hashPassword(
					$changePasswordForm->password, $user->salt
				);
				
				// Пытаемся обновить данные:
				$this->tryUpdate($user, $changePasswordForm->password, '/user/account/login');
			}
		}

		// Отрисовываем форму:
		$this->controller->render('changePassword', array('model' => $changePasswordForm));
    }
}