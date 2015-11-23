<?php

/**
 * Class EmailFeedbackSender
 */
class EmailFeedbackSender extends DbFeedbackSender implements IFeedbackSender
{
    /**
     * @param IFeedbackForm $form
     * @return bool
     */
    public function send(IFeedbackForm $form)
    {
        $emailBody = Yii::app()->controller->renderPartial('feedbackEmail', ['model' => $form], true);

        foreach (explode(',', $this->module->emails) as $mail) {
            $this->mail->send($form->getEmail(), $mail, $form->getTheme(), $emailBody);
        }

        if ($this->module->sendConfirmation) {
            $this->sendConfirmation($form);
        }

        return true;
    }

    /**
     * @param IFeedbackForm $form
     * @param FeedBack|null $feedBack
     * @return bool
     */
    public function sendConfirmation(IFeedbackForm $form, FeedBack $feedBack = null)
    {
        $emailBody = Yii::app()->controller->renderPartial(
            'feedbackConfirmationEmailEmpty',
            ['model' => $form],
            true
        );

        $result = $this->mail->send(
            $this->module->notifyEmailFrom,
            $form->getEmail(),
            Yii::t(
                'FeedbackModule.feedback',
                'Your proposition on site "{site}" was received',
                ['{site}' => Yii::app()->name]
            ),
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
