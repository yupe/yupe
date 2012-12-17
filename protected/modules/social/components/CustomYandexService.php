<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

Yii::import('social.extensions.eauth.services.*');

class CustomYandexService extends YandexOpenIDService
{
    protected $jsArguments = array('popup' => array(
        'width'  => 900,
        'height' => 620,
    ));

    protected $requiredAttributes = array(
        'name'      => array('fullname', 'namePerson'),
        'username'  => array('nickname', 'namePerson/friendly'),
        'email'     => array('email', 'contact/email'),
        'gender'    => array('gender', 'person/gender'),
        'birthDate' => array('dob', 'birthDate'),
    );

    protected function fetchAttributes()
    {
        if (isset($this->attributes['username']) && !empty($this->attributes['username']))
            $this->attributes['url'] = 'http://openid.yandex.ru/' . $this->attributes['username'];
        if (isset($this->attributes['birthDate']) && !empty($this->attributes['birthDate']))
            $this->attributes['birthDate'] = strtotime($this->attributes['birthDate']);

        // http://api.yandex.ru/openid/doc/dg/concepts/user-info.xml
        // получим ник и first_name
        $this->attributes['first_name'] = $this->attributes['name'];
        $this->attributes['last_name']  = '';
        $this->attributes['nick']       = empty($this->attributes['username']) ? $this->attributes['email'] : $this->attributes['username'];
    }
}