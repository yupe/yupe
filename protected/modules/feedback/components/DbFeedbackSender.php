<?php

use yupe\components\Mail;

/**
 * Class DbFeedbackSender
 */
class DbFeedbackSender implements IFeedbackSender
{
    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var FeedbackModule
     */
    protected $module;

    /**
     * DbFeedbackSender constructor.
     * @param Mail $mail
     * @param FeedbackModule $module
     */
    public function __construct(Mail $mail, FeedbackModule $module)
    {
        $this->mail = $mail;

        $this->module = $module;
    }

    /**
     * @param IFeedbackForm $form
     * @return bool
     */
    public function send(IFeedbackForm $form)
    {
        $feedback = new FeedBack();

        $feedback->setAttributes(
            [
                'name' => $form->getName(),
                'email' => $form->getEmail(),
                'theme' => $form->getTheme(),
                'text' => $form->getText(),
                'phone' => $form->getPhone(),
                'type' => $form->getType(),
            ]
        );

        if ($feedback->save()) {

            if ($this->module->sendConfirmation) {
                return $this->sendConfirmation($form, $feedback);
            }

            return true;
        }

        return false;
    }

    /**
     * @param IFeedbackForm $form
     * @param FeedBack|null $feedBack
     * @return bool
     */
    public function sendConfirmation(IFeedbackForm $form, FeedBack $feedBack = null)
    {
        $emailBody = Yii::app()->getController()->renderPartial(
            'feedbackConfirmationEmail',
            ['model' => $feedBack],
            true
        );

        return $this->mail->send(
            $this->module->notifyEmailFrom,
            $form->getEmail(),
            Yii::t(
                'FeedbackModule.feedback',
                'Your proposition on site "{site}" was received',
                ['{site}' => Yii::app()->name]
            ),
            $emailBody
        );

        return $result;
    }
}
