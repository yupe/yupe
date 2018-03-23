<?php

namespace application\modules\social\components\services;

use \VKontakteOAuthService;

class VKontakte extends VKontakteOAuthService
{
    const AUTH_DATA_KEY = 'authData';

    public function authenticate()
    {
        if (parent::authenticate()) {
            $this->setState(
                self::AUTH_DATA_KEY,
                [
                    'uid'     => $this->getId(),
                    'service' => $this->getServiceName(),
                    'type'    => $this->getServiceType(),
                ]
            );

            return true;
        }

        return false;
    }
    /** Request user attributes
     *
     * @return void
     */
    protected function fetchAttributes() {
        $info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
            'query' => array(
                'user_ids' => $this->uid,
                'version'    => '5.50', // без указания данного параметра, контакт теперь не работает
                'fields' => '', // uid, first_name and last_name is always available
                //'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
            ),
        ));

        $info = $info['response'][0];

        $this->attributes['id'] = $info->uid;
        $this->attributes['name'] = $info->first_name . ' ' . $info->last_name;
        $this->attributes['url'] = 'http://vk.com/id' . $info->uid;

    }

    /**
     * Returns the url to request to get OAuth2 code.
     *
     * @param string $redirect_uri url to redirect after user confirmation.
     * @return string url to request.
     */
    protected function getCodeUrl($redirect_uri) {
        $this->setState('redirect_uri', $redirect_uri);

        $url = parent::getCodeUrl($redirect_uri);
        if (isset($_GET['js'])) {
            $url .= '&display=popup';
        }
        $url_parts = parse_url($url);
        if (!isset($url_parts['v']) || !isset($url_parts['version'])) {
            $url .= '&v=5.50';
        }
        return $url;
    }

    /**
     * Returns the url to request to get OAuth2 access token.
     *
     * @param string $code
     * @return string url to request.
     */
    protected function getTokenUrl($code) {
        $url = parent::getTokenUrl($code);
        $url_parts = parse_url($url);
        if (!isset($url_parts['v']) || !isset($url_parts['version'])) {
            $url .= '&v=5.50';
        }
        return $url;
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
