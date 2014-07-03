<?php

interface IFeedbackSender {
    public function send(FeedBackForm $form);
    public function sendConfirmation(FeedBackForm $form, FeedBack $feedBack = null);
} 