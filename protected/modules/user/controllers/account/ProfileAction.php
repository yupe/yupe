<?php
class ProfileAction extends CAction
{
    public function run()
    {
        if (!Yii::app()->user->isAuthenticated())
        {
            $this->controller->redirect(array('/user/account/login'));
        }

        $user = Yii::app()->user->getProfile();

        if (Yii::app()->request->isPostRequest && isset($_POST['Profile']))
        {
            // сохраним старое значение аватара
            $avatar = $user->avatar;

            $user->setAttributes($_POST['User']);

            if (isset($_FILES['User']['size']['avatar']) && $_FILES['User']['size']['avatar'] > 0)
            {
                $user->avatar = CUploadedFile::getInstance($user, 'avatar');
                $avatarFullPath = Yii::app()->getModule('user')->documentRoot . Yii::app()->getModule('user')->avatarsDir . Yii::app()->user->getId() . ".{$user->avatar->getExtensionName()}";
                $avatarName = Yii::app()->getModule('user')->avatarsDir . Yii::app()->user->getId() . ".{$user->avatar->getExtensionName()}";
            }
            else
            {
                // если новый аватар не передаем - оставляем старый
                $user->avatar = $avatar;
            }

            if ($user->save() && $user->profile->save())
            {
                if (isset($_FILES['User']['size']['avatar']) && $_FILES['User']['size']['avatar'] > 0)
                {
                    if ($user->avatar->saveAs($avatarFullPath))
                    {
                        $user->avatar = $avatarName;
                        $user->update(array('avatar'));
                    }
                }
                Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('user', 'Ваш профиль обновлен!'));
                $this->controller->redirect(array('/user/account/profile'));
            }
        }

        $this->controller->render('profile', array('model' => $user));
    }
}

?>
