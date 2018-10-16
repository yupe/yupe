<?php
use yupe\components\Event;

/**
 * Class UserRegistrationEvent
 */
class UserRegistrationEvent extends Event
{
    /**
     * @var
     */
    protected $token;

    /**
     * @var RegistrationForm
     */
    protected $form;

    /**
     * @var User
     */
    protected $user;


    /**
     * UserRegistrationEvent constructor.
     * @param RegistrationForm $form
     * @param User $user
     * @param UserToken|null $token
     */
    public function __construct(RegistrationForm $form, User $user, UserToken $token = null)
    {
        $this->form = $form;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
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
