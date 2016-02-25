<?php

/**
 * Interface IFeedbackSender
 */
interface IFeedbackSender
{
    /**
     * @param IFeedbackForm $form
     * @return mixed
     */
    public function send(IFeedbackForm $form);

    /**
     * @param IFeedbackForm $form
     * @param FeedBack|null $feedBack
     * @return mixed
     */
    public function sendConfirmation(IFeedbackForm $form, FeedBack $feedBack = null);
}
