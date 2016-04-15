<?php
namespace application\modules\social\components\services;

use \FacebookOAuthService;

class Facebook extends FacebookOAuthService
{
    const AUTH_DATA_KEY = 'authData';

    protected function fetchAttributes()
    {
        $this->attributes = (array)$this->makeSignedRequest('https://graph.facebook.com/me');
    }

    public function authenticate()
    {
        if (parent::authenticate()) {
            $this->setState(
                self::AUTH_DATA_KEY,
                [
                    'email'   => $this->email,
                    'uid'     => $this->getId(),
                    'service' => $this->getServiceName(),
                    'type'    => $this->getServiceType(),
                ]
            );

            return true;
        }

        return false;
    }

    public function getAuthData()
    {
        return $this->getState(self::AUTH_DATA_KEY);
    }

    public function cleanAuthData()
    {
        $this->setState(self::AUTH_DATA_KEY, null);
    }
}
