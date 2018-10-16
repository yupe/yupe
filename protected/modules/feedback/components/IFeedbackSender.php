<?php

interface IFeedbackSender
{
    public function send(IFeedbackForm $form);

    public function sendConfirmation(IFeedbackForm $form, FeedBack $feedBack = null);
}
