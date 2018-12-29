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

    /**
     * @return bool|void
     * @throws \CHttpException
     */
    protected function fetchAttributes() {
        $info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
            'query' => array(
                'user_ids' => $this->uid,
                'version'    => '5.50',
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
     * @param string $redirect_uri
     * @return string
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
     * @param string $code
     * @return string
     */
    protected function getTokenUrl($code) {
        $url = parent::getTokenUrl($code);
        $url_parts = parse_url($url);
        if (!isset($url_parts['v']) || !isset($url_parts['version'])) {
            $url .= '&v=5.50';
        }
        return $url;
    }

    /**
     * @return mixed
     */
    public function getAuthData()
    {
        return $this->getState(self::AUTH_DATA_KEY);
    }

    public function cleanAuthData()
    {
        $this->setState(self::AUTH_DATA_KEY, null);
    }
}
