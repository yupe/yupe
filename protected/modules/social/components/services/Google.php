<?php
namespace application\modules\social\components\services;

class Google extends \GoogleOAuthService
{
    protected $scope = 'https://www.googleapis.com/auth/userinfo.email';
    protected $name = 'google';

    const AUTH_DATA_KEY = 'authData';

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

    protected function fetchAttributes() {
        $info = (array)$this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');

        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = $info['name'];
        $this->attributes['email'] = $info['email'];

        if (!empty($info['link'])) {
            $this->attributes['url'] = $info['link'];
        }
    }
}
