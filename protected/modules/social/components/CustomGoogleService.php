<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

Yii::import('social.extensions.eauth.services.*');

class CustomGoogleService extends GoogleOpenIDService
{
    protected $jsArguments = array('popup' => array(
        'width'  => 450,
        'height' => 450,
    ));

    protected $requiredAttributes = array(
        'name'     => array('firstname', 'namePerson/first'),
        'lastname' => array('lastname', 'namePerson/last'),
        'email'    => array('email', 'contact/email'),
        'language' => array('language', 'pref/language'),
    );

    protected function fetchAttributes()
    {
        $this->attributes['first_name'] = $this->attributes['name'];
        $this->attributes['last_name']  = $this->attributes['lastname'];
        $this->attributes['nick']       = $this->attributes['email'];
    }
}