<?php

interface IFeedbackSender {
    public function send(FeedBackForm $form);
    public function sendConfirmation(FeedBackForm $feedback);
} 