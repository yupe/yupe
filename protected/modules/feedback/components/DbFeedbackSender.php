<?php

use yupe\components\Mail;

class DbFeedbackSender implements IFeedbackSender
{
    protected $mail;

    protected $module;

    public function __construct(Mail $mail, FeedbackModule $module)
    {
        $this->mail = $mail;

        $this->module = $module;
    }

    public function send(FeedBackForm $form)
    {
        $feedback = new FeedBack;

        $feedback->setAttributes(array(
            'name' => $form->name,
            'email' => $form->email,
            'theme' => $form->theme,
            'text' => $form->text,
            'phone' => $form->phone,
            'type' => $form->type,
        ));



        if ($feedback->save()) {

            if ($this->module->sendConfirmation) {

                return $this->sendConfirmation($form, $feedback);
            }

            return true;
        }

        return false;
    }

    public function sendConfirmation(FeedBackForm $form, FeedBack $feedBack = null)
    {
        $emailBody = Yii::app()->controller->renderPartial('feedbackConfirmationEmail', array('model' => $feedBack), true);

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