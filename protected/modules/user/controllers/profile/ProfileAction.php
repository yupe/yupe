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
        $user = $this->getController()->user;

        $form = new ProfileForm();

        $formAttributes = $form->getAttributes();

        unset($formAttributes['avatar'], $formAttributes['verifyCode']);

        $form->setAttributes($user->getAttributes(array_keys($formAttributes)));

        // Если у нас есть данные из POST - получаем их:
        if (($data = Yii::app()->getRequest()->getPost('ProfileForm')) !== null) {

            $transaction = Yii::app()->getDb()->beginTransaction();

            try {

                $form->setAttributes($data);

                if ($form->validate()) {
                    // Удаляем ненужные данные:
                    unset($data['avatar']);

                    // Заполняем модель данными:
                    $user->setAttributes($data);

                    // Если есть ошибки в профиле - перекинем их в форму
                    if ($user->hasErrors()) {
                        $form->addErrors($user->getErrors());
                    }

                    // Если у нас есть дополнительные профили - проверим их
                    foreach ((array)$this->getController()->module->profiles as $p) {
                        $p->validate() || $form->addErrors($p->getErrors());
                    }

                    // Если нет ошибок валидации:
                    if ($form->hasErrors() === false) {

                        Yii::log(
                            Yii::t(
                                'UserModule.user',
                                'Profile for #{id}-{nick_name} was changed',
                                [
                                    '{id}' => $user->id,
                                    '{nick_name}' => $user->nick_name,
                                ]
                            ),
                            CLogger::LEVEL_INFO,
                            UserModule::$logCategory
                        );

                        Yii::app()->getUser()->setFlash(
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Your profile was changed successfully')
                        );

                        if (($uploadedFile = CUploadedFile::getInstance($form, 'avatar')) !== null) {
                            $user->changeAvatar($uploadedFile);
                        } elseif ($form->use_gravatar) {
                            $user->removeOldAvatar();
                        };

                        $user->save();

                        // И дополнительные профили, если они есть
                        if (is_array($this->getController()->module->profiles)) {
                            foreach ($this->getController()->module->profiles as $k => $p) {
                                $p->save(false);
                            }
                        }

                        Yii::app()->getUser()->setFlash(
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('UserModule.user', 'Profile was updated')
                        );

                        $transaction->commit();

                        $this->getController()->redirect(['/user/profile/profile']);

                    } else {

                        Yii::log(
                            Yii::t('UserModule.user', 'Error when save profile! #{id}', ['{id}' => $user->id]),
                            CLogger::LEVEL_ERROR,
                            UserModule::$logCategory
                        );
                    }
                }

            } catch (Exception $e) {

                $transaction->rollback();

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        $this->getController()->render(
            'profile',
            [
                'model' => $form,
                'module' => Yii::app()->getModule('user'),
                'user' => $user
            ]
        );
    }
}
