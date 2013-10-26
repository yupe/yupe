<?php
/**
 * Экшн, отвечающий за запрос восстановления пароля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class RecoveryAction extends CAction
{
    public function run()
    {
        $module = Yii::app()->getModule('user');

        // Если восстановление отключено - ошбочка ;)
        if ($module->recoveryDisabled){
        	throw new CHttpException(
                404,
                Yii::t('UserModule.user', 'requested page was not found!')
            );
        }

        // Незачем выполнять последующие действия
        // для зарегистрированного пользователя:
        if (Yii::app()->user->isAuthenticated()) {
            $this->controller->redirect(
                Yii::app()->getUser()->getReturnUrl()
            );
        }

        // Новая форма восстановления пароля:
        $form = new RecoveryForm;

        // Получаем POST-данные:
        if (($data = Yii::app()->getRequest()->getPost('RecoveryForm')) !== null) {
            
            // Заполняем форму
            $form->setAttributes($data);

            // Если всё ок и данные валидны:
            if ($form->validate()) {
                
                // Дёргаем пользователя из формы:
                $user = $form->getUser();

                // Открываем транзакцию:
                $transaction = Yii::app()->getDb()->beginTransaction();

                try {

                    // Если уже есть токен на восстановление - инвалидируем токен:
                    $user->recovery instanceof UserToken === false || $user->recovery->compromise();

                    // Создаём новый токен на восстановление пароля
                    // или меняем пароль при автоматическ:
                    // Так как параметры хранятся в varchar... используем === "1"
                    if ($module->autoRecoveryPassword === "1" || UserToken::newRecovery($user)) {
                        
                        // Если необходимо - выполняем смену пароля:
                        $module->autoRecoveryPassword === false || $user->changePassword(
                            // Генерируем и запоминаем новый пароль:
                            $new_password = User::generateRandomPassword(
                                $module->minPasswordLength
                            )
                        );

                        // Обновляем данные, получая новый токен:
                        $user->with('recovery')->refresh();

                        // Генерируем тело письма:
                        $emailBody = $module->autoRecoveryPassword === "1"
                            // Автоматическая генерация пароля с его
                            // отпрвкой пользователю (без токена):
                            ? $this->controller->renderPartial(
                                'passwordAutoRecoveryEmail', array(
                                    'password' => $new_password
                                ), true
                            )
                            // Генерация токена и отправка пользователю
                            // токена на восстановление:
                            : $this->controller->renderPartial(
                                'passwordRecoveryEmail', array(
                                    'model' => $user
                                ), true
                            );

                        // Отправляем письмо:
                        Yii::app()->mail->send(
                            $module->notifyEmailFrom,
                            $user->email,
                            Yii::t('UserModule.user', 'Password recovery!'),
                            $emailBody
                        );

                        // Делаем запись в лог:
                        Yii::log(
                            $module->autoRecoveryPassword === "1"
                                ? Yii::t('UserModule.user', 'Automatic password recovery request')
                                : Yii::t('UserModule.user', 'Password recovery request'),
                            CLogger::LEVEL_INFO, UserModule::$logCategory
                        );
                        
                        // Сообщаем пользователю:
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t(
                                'UserModule.user',
                                'Letter with password recovery instructions was sent on email which you choose during register'
                            )
                        );

                        // Сохраняем правки:
                        $transaction->commit();
                        
                        // Выполняем переадресацию на страницу авторизации:
                        $this->controller->redirect(array('/user/account/login'));
                    } else {

                        // Сообщаем об ошибке создав исключение:
                        throw new Exception(
                            Yii::t('UserModule.user', 'Password recovery error.')
                        );
                        
                    }
                } catch (Exception $e) {

                    // Откатываем изменения:
                    $transaction->rollBack();

                    // Сообщаем об ошибке пользователю:
                    Yii::app()->user->setFlash(
                        YFlashMessages::ERROR_MESSAGE,
                        Yii::t('UserModule.user', 'Password recovery error.')
                    );

                    // Записываем информацию в лог:
                    Yii::log(
                        Yii::t('UserModule.user', 'Password recovery error.'),
                        CLogger::LEVEL_ERROR, UserModule::$logCategory
                    );

                }
            }
        }

        $this->controller->render('recovery', array('model' => $form));
    }
}