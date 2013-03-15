<?php
class ServiceUserIdentity extends UserIdentity
{
    const ERROR_NOT_AUTHENTICATED = 3;
    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        if ($this->service->isAuthenticated)
        {
            $this->username = $this->service->getAttribute('name');
            Yii::app()->user->setState('sid', $this->service->id);
            Yii::app()->user->setState('name', $this->username);
            Yii::app()->user->setState('service', $this->service->serviceName);
            $this->errorCode = self::ERROR_NONE;
        }
        else
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        return !$this->errorCode;
    }
}