<?php

class EmailFeedbackSender extends DbFeedbackSender implements IFeedbackSender
{
    public function send(FeedBackForm $form)
    {
        $emailBody = Yii::app()->controller->renderPartial('feedbackEmail', array('model' => $form), true);

        foreach (explode(',', $this->module->emails) as $mail) {
            $this->mail->send($form->email, $mail, $form->theme, $emailBody);
        }

        if ($this->module->sendConfirmation) {
            $this->feedbackConfirmationEmail($form);
        }

        return true;
    }
} 