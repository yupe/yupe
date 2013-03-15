<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

Yii::import('social.extensions.eauth.services.*');

class CustomTwitterService extends TwitterOAuthService
{
    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('https://api.twitter.com/1/account/verify_credentials.json');

        $this->attributes['id']         = $info->id;
        $this->attributes['name']       = $info->name;
        $this->attributes['url']        = 'http://twitter.com/account/redirect_by_id?id=' . $info->id_str;

        $this->attributes['nick']       = $info->name;
        $this->attributes['first_name'] = $info->screen_name;
        $this->attributes['last_name']  = '';
        $this->attributes['username']   = $info->screen_name;
        $this->attributes['language']   = $info->lang;
        $this->attributes['timezone']   = timezone_name_from_abbr('', $info->utc_offset, date('I'));
        $this->attributes['photo']      = $info->profile_image_url;
    }
}