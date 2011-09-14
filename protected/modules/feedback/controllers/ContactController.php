<?php
class ContactController extends YFrontController
{

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
        );
    }

    public function actionIndex()
    {
        $form = new FeedBackForm();

        if (Yii::app()->request->isPostRequest && isset($_POST['FeedBackForm'])) {
            $form->setAttributes($_POST['FeedBackForm']);

            if ($form->validate()) {
                // обработка запроса
                $backEnd = array_unique(Yii::app()->getModule('feedback')->backEnd);

                if (is_array($backEnd) && count($backEnd)) {
                    // запись в базу
                    if (in_array('db', $backEnd)) {
                        $feedback = new FeedBack();

                        $feedback->setAttributes(array(
                                                      'name' => $form->name,
                                                      'email' => $form->email,
                                                      'theme' => $form->theme,
                                                      'text' => $form->text,
                                                      'type' => $form->type
                                                 ));

                        if ($feedback->save()) {
                            Yii::log(Yii::t('feedback', 'Обращение пользователя добавлено в базу!'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);

                            Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('feedback', 'Ваше сообщение отправлено! Спасибо!'));
                        }
                        else
                        {
                            $form->addErrors($feedback->getErrors());
                            Yii::log(Yii::t('feedback', 'Ошибка при добавлении обращения пользователя в базу!'), CLogger::LEVEL_ERROR, FeedbackModule::$logCategory);
                            Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE, Yii::t('feedback', 'При отправке сообщения произошла ошибка! Повторите попытку позже!'));
                            $this->render('index', array('model' => $form));
                        }
                    }

                    if (in_array('email', $backEnd) && count(Yii::app()->getModule('feedback')->emails)) {
                        $emailBody = $this->renderPartial('application.modules.feedback.views.email.feedbackEmail', array('model' => $feedback), true);
                        foreach (Yii::app()->getModule('feedback')->emails as $mail)
                        {
                            Yii::app()->mail->send(Yii::app()->getModule('feedback')->notifyEmailFrom, $mail, $form->theme, $emailBody);
                        }

                        Yii::log(Yii::t('feedback', 'Обращение пользователя отправлено на email!'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);
                        Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('feedback', 'Ваше сообщение отправлено! Спасибо!'));
                        $this->redirect(array('/feedback/contact'));
                    }
                }
            }
        }

        $this->render('index', array('model' => $form));
    }
}