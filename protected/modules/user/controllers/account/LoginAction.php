<?php 
class LoginAction extends CAction
{
    public function run()
    {
        $form = new LoginForm();

        if (Yii::app()->request->isPostRequest && isset($_POST['LoginForm'])) {
            $form->setAttributes($_POST['LoginForm']);

            if ($form->validate()) {
                Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('user', 'Вы успешно авторизовались!'));
                Yii::log(Yii::t('user', 'Пользователь {user} авторизовался!', array('{user}' => $form->email)), CLogger::LEVEL_INFO, UserModule::$logCategory);
                $this->controller->redirect(array(Yii::app()->getModule('user')->loginSuccess));
            }
            else
            {
                Yii::log(Yii::t('user', 'Ошибка авторизации! Email => {email}, Password => {password}!', array('{email}' => $form->email, '{password}' => $form->password)), CLogger::LEVEL_ERROR, UserModule::$logCategory);
            }
        }

        $this->controller->render('login', array('model' => $form));
    }
}

?>
