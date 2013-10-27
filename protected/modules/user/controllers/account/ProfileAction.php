<?php
/**
 * Экшн, отвечающий за редактирование профиля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class ProfileAction extends CAction
{
    public function run()
    {
        // Так, кто у нас тут? Ага, гость - идика воооон туда:
        if (Yii::app()->user->isAuthenticated() === false) {
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }

        // Инициализируем форму:
        $form = new ProfileForm;
        
        // Получаем профиль пользователя:
        if (($user = Yii::app()->user->getProfile()) === null) {
            // Сообщаем об ошибке:
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'User not found.')
            );

            // На всякий случай:
            Yii::app()->user->logout();

            // Переадресовываем на соответствующую ошибку:
            $this->controller->redirect(
                (array) '/user/account/login'
            );
        }
        
        // Заполняем поля формы:
        $form->setAttributes(
            $user->getAttributes()
        );
        
        // Очищаем необходимые поля:
        $form->password = $form->cPassword = null;

        // Получаем модуль:
        $module = Yii::app()->getModule('user');

        // Открываем ивент:
        $event = new CModelEvent($this->controller);
        $module->onBeginProfile($event);

        // Если у нас есть данные из POST - получаем их:
        if (($data = Yii::app()->getRequest()->getPost('ProfileForm')) !== null) {

            // Открываем транзакцию:
            $transaction = Yii::app()->db->beginTransaction();

            try {
                // Заполняем атрибуты формы:
                $form->setAttributes($data);

                // Проводим валидацию формы:
                if ($form->validate() === true) {
                    
                    // Новый пароль? - ок, запоминаем:
                    $newPass = isset($data['password'])
                                ? $data['password']
                                : null;
                    
                    // Удаляем ненужные данные:
                    unset($data['password'], $data['avatar']);

                    // Запоминаем старую почту,
                    $oldEmail = $user->email;
                    
                    // Заполняем модель данными:
                    $user->setAttributes($data);

                    // Новый пароль? - Генерируем хеш:
                    if ($newPass) {
                        $user->password = User::hashPassword($newPass);
                    }

                    // Если есть ошибки в профиле - перекинем их в форму
                    if ($user->hasErrors()) {
                        $form->addErrors($user->getErrors());
                    }

                    // Если у нас есть дополнительные профили - проверим их
                    foreach ((array) $this->controller->module->profiles as $p) {
                        
                        // Есть ошибки? - Добавляем их в форму:
                        $p->validate() === true || $form->addErrors(
                            $p->getErrors()
                        );
                    
                    }

                    // Если нет ошибок валидации:
                    if ($form->hasErrors() === false) {
                        
                        // Говорим о событии в лог-файл:
                        Yii::log(
                            Yii::t(
                                'UserModule.user',
                                'Profile for #{id}-{nick_name} was changed',
                                array(
                                    '{id}' => $user->id,
                                    '{nick_name}' => $user->nick_name,
                                )
                            ),
                            CLogger::LEVEL_INFO,
                            UserModule::$logCategory
                        );
                        
                        // Всё гуд? - Сообщаем пользователю:
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Your profile was changed successfully')
                        );

                        //Обновляем аватарку                    
                        if ($uploadedFile = CUploadedFile::getInstance($form, 'avatar')) {
                            $user->changeAvatar($uploadedFile);
                        }

                        // Сохраняем профиль
                        $user->save(false);

                        // И дополнительные профили, если они есть
                        if (is_array($this->controller->module->profiles)) {
                            foreach ($this->controller->module->profiles as $k => $p) {
                                $p->save(false);
                            }
                        }

                        // Сообщаем пользователю:
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Profile was updated')
                        );

                        // Коммитим:
                        $transaction->commit();

                        // Если включена верификация при смене почты:
                        if ($module->emailAccountVerification && ($oldEmail != $form->email)) {
                            
                            // Выполняем отправку:
                            yupe\components\Token::sendEmailVerify(
                                $user, '//user/account/needEmailActivationEmail', true
                            );

                            // Сообщаем пользователю:
                            Yii::app()->user->setFlash(
                                YFlashMessages::SUCCESS_MESSAGE,
                                Yii::t(
                                    'UserModule.user',
                                    'You need to confirm your e-mail. Please check the mail!'
                                )
                            );
                        }
                        
                        // Переадресовываем куда нужно =)
                        $this->controller->redirect(array('/user/account/profile'));
                    
                    } else {
                        
                        // Произошла ошибка? - Пишем в лог-файл:
                        Yii::log(
                            Yii::t('UserModule.user', 'Error when save profile! #{id}', array('{id}' => $user->id)),
                            CLogger::LEVEL_ERROR,
                            UserModule::$logCategory
                        );
                    }
                }
            
            // Ловим ошибочки:
            } catch(Exception $e) {
                
                // Откатываем правки:
                $transaction->rollback();
                
                // Сообщаем о проблеме пользователю:
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        // Рендерим вьюшку:
        $this->controller->render(
            'profile', array(
                'model'  => $form,
                'module' => $module,
                'user'   => $user
            )
        );
    }
}