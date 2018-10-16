<?php

/**
 * Class FeedbackSendEvent
 */
class FeedbackSendEvent extends \yupe\components\Event
{
    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $feedback;

    /**
     * FeedbackSendEvent constructor.
     * @param $user
     * @param $feedback
     */
    public function __construct($user, $feedback)
    {
        $this->user = $user;
        $this->feedback = $feedback;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param mixed $feedback
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
    }
}