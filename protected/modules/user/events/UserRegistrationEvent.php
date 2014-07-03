<?php
use yupe\components\Event;

/**
 * Class UserRegistrationEvent
 */
class UserRegistrationEvent extends Event
{
    /**
     * @var RegistrationForm
     */
    protected $form;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param RegistrationForm $form
     * @param User $user
     */
    function __construct(RegistrationForm $form, User $user)
    {
        $this->form = $form;
        $this->user = $user;
    }

    /**
     * @param \RegistrationForm $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * @return \RegistrationForm
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }
} 