<?php
/**
 * LiveOAuthService class file.
 *
 * Register application: https://manage.dev.live.com/Applications/Index
 *
 * @author https://github.com/pavlepredic
 * @link https://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

/**
 * Microsoft Live provider class.
 *
 * @package application.extensions.eauth.services
 */
class LiveOAuthService extends EOAuth2Service {

	protected $name = 'live';
	protected $title = 'Live';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = 'wl.emails';
	protected $providerOptions = array(
		'authorize' => 'https://login.live.com/oauth20_authorize.srf',
		'access_token' => 'https://login.live.com/oauth20_token.srf',
	);

	protected function fetchAttributes() {
		$info = (object)$this->makeSignedRequest('https://apis.live.net/v5.0/me');

		$this->attributes['id'] = $info->id;
		$this->attributes['name'] = $info->name;
		$this->attributes['url'] = 'https://profile.live.com/cid-' . $info->id . '/';

		/*$this->attributes['email'] = $info->emails->account;
		$this->attributes['first_name'] = $info->first_name;
		$this->attributes['last_name'] = $info->last_name;
		$this->attributes['gender'] = $info->gender;
		$this->attributes['locale'] = $info->locale;*/
	}

	protected function getTokenUrl($code) {
		return parent::getTokenUrl($code) . '&grant_type=authorization_code&redirect_uri=' . urlencode($this->getState('redirect_uri'));
	}

	protected function getAccessToken($code) {
		//live returns an instance of stdClass as access token; the actual token is stored as access_token property
		return $this->makeRequest($this->getTokenUrl($code))->access_token;
	}

	protected function getCodeUrl($redirectUri) {
		//store redirect uri in session; we need to use it when requesting an access token
		$this->setState('redirect_uri', $redirectUri);
		return parent::getCodeUrl($redirectUri);
	}
}