<?php
namespace application\modules\social\components\services;

use \GoogleOpenIDService;

class Google extends GoogleOpenIDService
{
    const AUTH_DATA_KEY = 'authData';

    public function authenticate()
    {
        if (parent::authenticate()) {
            $this->setState(
                self::AUTH_DATA_KEY,
                array(
                    'email'   => $this->email,
                    'uid'     => $this->getId(),
                    'service' => $this->getServiceName(),
                    'type'    => $this->getServiceType(),
                )
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
