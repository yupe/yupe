<?php

class EmailFeedbackSender extends  DbFeedbackSender implements IFeedbackSender
{
    public function send(FeedBackForm $form)
    {
        $emailBody = Yii::app()->controller->renderPartial('feedbackEmail', array('model' => $form), true);

        foreach (explode(',', $this->module->emails) as $mail) {
            $this->mail->send($form->email, $mail, $form->theme, $emailBody);
        }

        if ($this->module->sendConfirmation) {
            $this->sendConfirmation($form);
        }

        return true;
    }

    public function sendConfirmation(FeedBackForm $form, FeedBack $feedBack = null)
    {
        $emailBody = Yii::app()->controller->renderPartial('feedbackConfirmationEmailEmpty', array('model' => $form), true);

        $result = $this->mail->send(
            $this->module->notifyEmailFrom,
            $form->email,
            Yii::t('FeedbackModule.feedback', 'Your proposition on site "{site}" was received', array('{site}' => Yii::app()->name)),
            $emailBody
        );

        if ($result) {
            Yii::log(
                Yii::t('FeedbackModule.feedback', 'Feedback: Notification for user was sent to email successfully'),
                CLogger::LEVEL_INFO,
                FeedbackModule::$logCategory
            );
        } else {
            Yii::log(
                Yii::t('FeedbackModule.feedback', 'Feedback: can\'t send message'),
                CLogger::LEVEL_INFO,
                FeedbackModule::$logCategory
            );
        }

        return $result;
    }
} 