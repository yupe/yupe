<?php
/**
 * An example of extending the provider class.
 *
 * @author ChooJoy <choojoy.work@gmail.com>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

Yii::import('social.extensions.eauth.services.*');

class CustomMailruService extends MailruOAuthService
{
    protected function fetchAttributes()
    {
        $info = (array) $this->makeSignedRequest('http://www.appsmail.ru/platform/api', array('query' => array(
            'uids'   => $this->getUid(),
            'method' => 'users.getInfo',
            'app_id' => $this->client_id,
        )));

        $info = $info[0];
        // http://api.mail.ru/docs/reference/rest/users-getinfo/

        $this->attributes['id']         = $info->uid;
        $this->attributes['first_name'] = $info->first_name;
        $this->attributes['last_name']  = $info->last_name;
        $this->attributes['nick']       = $info->nick;
        $this->attributes['photo']      = $info->pic;
    }
}