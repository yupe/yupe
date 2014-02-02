<?php
/**
 * Экшн, отвечающий за редактирование профиля пользователя
 *
 * @category YupeComponents
 * @package  yupe.modules.user.controllers.account
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.7
 * @link     http://yupe.ru
 *
 **/
class ProfileAction extends CAction
{
    public function run()
    {
        if (Yii::app()->user->isAuthenticated() === false) {
            $this->controller->redirect(Yii::app()->user->loginUrl);
        }        

        if (($user = Yii::app()->user->getProfile()) === null) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('UserModule.user', 'User not found.')
            );

            Yii::app()->user->logout();

            $this->controller->redirect(
                (array) '/user/account/login'
            );
        }

        $form = new ProfileForm;

        $formAttributes = $form->getAttributes();

        unset($formAttributes['avatar'], $formAttributes['verifyCode']);

        $form->setAttributes($user->getAttributes(array_keys($formAttributes)));
        
        // Очищаем необходимые поля:
        $form->password = $form->cPassword = null;

        $module = Yii::app()->getModule('user');

        // Открываем ивент:
        $event = new CModelEvent($this->controller, array("profileForm" => $form));
        $module->onBeginProfile($event);

        // Если у нас есть данные из POST - получаем их:
        if (($data = Yii::app()->getRequest()->getPost('ProfileForm')) !== null) {

            $transaction = Yii::app()->db->beginTransaction();

            try {

                $form->setAttributes($data);

                if ($form->validate()) {
                    
                    // Новый пароль? - ок, запоминаем:
                    $newPass = isset($data['password'])? $data['password'] : null;
                    
                    // Удаляем ненужные данные:
                    unset($data['password'], $data['avatar']);

                    // Запоминаем старую почту,
                    $oldEmail = $user->email;
                    
                    // Заполняем модель данными:
                    $user->setAttributes($data);

                    // Новый пароль? - Генерируем хеш:
                    if ($newPass) {
                        $user->hash = Yii::app()->userManager->hasher->hashPassword($newPass);
                    }

                    // Если есть ошибки в профиле - перекинем их в форму
                    if ($user->hasErrors()) {
                        $form->addErrors($user->getErrors());
                    }

                    // Если у нас есть дополнительные профили - проверим их
                    foreach ((array) $this->controller->module->profiles as $p) {
                        $p->validate() || $form->addErrors($p->getErrors());
                    }

                    // Если нет ошибок валидации:
                    if ($form->hasErrors() === false) {

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

                        Yii::app()->user->setFlash(
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Your profile was changed successfully')
                        );

                        if($form->use_gravatar) {
                            $user->avatar = null;
                        }elseif(($uploadedFile = CUploadedFile::getInstance($form, 'avatar')) !== null){                                                        
                            $user->changeAvatar($uploadedFile);
                        }

                        // Сохраняем профиль
                        $user->save();

                        // И дополнительные профили, если они есть
                        if (is_array($this->controller->module->profiles)) {
                            foreach ($this->controller->module->profiles as $k => $p) {
                                $p->save(false);
                            }
                        }

                        Yii::app()->user->setFlash(
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Profile was updated')
                        );


                        $transaction->commit();

                        // Если включена верификация при смене почты:
                        if ($module->emailAccountVerification && ($oldEmail != $form->email)) {

                            if(Yii::app()->userManager->changeUserEmail($user, $form->email)) {
                                Yii::app()->user->setFlash(
                                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                                    Yii::t(
                                        'UserModule.user',
                                        'You need to confirm your e-mail. Please check the mail!'
                                    )
                                );
                            }
                        }

                        $module->onSuccessEditProfile(
                            new CModelEvent($this->controller, array("profileForm" => $form))
                        );
                        $this->controller->redirect(array('/user/account/profile'));
                    
                    } else {

                        $module->onErrorEditProfile(
                            new CModelEvent($this->controller, array("profileForm" => $form))
                        );

                        Yii::log(
                            Yii::t('UserModule.user', 'Error when save profile! #{id}', array('{id}' => $user->id)),
                            CLogger::LEVEL_ERROR,
                            UserModule::$logCategory
                        );
                    }
                }

            } catch(Exception $e) {

                $transaction->rollback();

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        $this->controller->render(
            'profile', array(
                'model'  => $form,
                'module' => $module,
                'user'   => $user
            )
        );
    }
}