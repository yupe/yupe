<?php
/**
 * VKontakteOAuthService class file.
 *
 * Register application: http://vk.com/editapp?act=create&site=1
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

/**
 * VKontakte provider class.
 *
 * @package application.extensions.eauth.services
 */
class VKontakteOAuthService extends EOAuth2Service {

	protected $name = 'vkontakte';
	protected $title = 'VK.com';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 585, 'height' => 350));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = 'friends';
	protected $providerOptions = array(
		'authorize' => 'http://api.vk.com/oauth/authorize',
		'access_token' => 'https://api.vk.com/oauth/access_token',
	);

	protected $uid = null;

	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
			'query' => array(
				'uids' => $this->uid,
				'fields' => '', // uid, first_name and last_name is always available
				//'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
			),
		));

		$info = $info['response'][0];

		$this->attributes['id'] = $info->uid;
		$this->attributes['name'] = $info->first_name . ' ' . $info->last_name;
		$this->attributes['url'] = 'http://vk.com/id' . $info->uid;

		/*if (!empty($info->nickname))
			$this->attributes['username'] = $info->nickname;
		else
			$this->attributes['username'] = 'id'.$info->uid;

		$this->attributes['gender'] = $info->sex == 1 ? 'F' : 'M';

		$this->attributes['city'] = $info->city;
		$this->attributes['country'] = $info->country;

		$this->attributes['timezone'] = timezone_name_from_abbr('', $info->timezone*3600, date('I'));;

		$this->attributes['photo'] = $info->photo;
		$this->attributes['photo_medium'] = $info->photo_medium;
		$this->attributes['photo_big'] = $info->photo_big;
		$this->attributes['photo_rec'] = $info->photo_rec;*/
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

		return $url;
	}

	/**
	 * Save access token to the session.
	 *
	 * @param stdClass $token access token object.
	 */
	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token->access_token);
		$this->setState('uid', $token->user_id);
		$this->setState('expires', $token->expires_in === 0 ? (time() * 2) : (time() + $token->expires_in - 60));
		$this->uid = $token->user_id;
		$this->access_token = $token->access_token;
	}

	/**
	 * Restore access token from the session.
	 *
	 * @return boolean whether the access token was successfuly restored.
	 */
	protected function restoreAccessToken() {
		if ($this->hasState('uid') && parent::restoreAccessToken()) {
			$this->uid = $this->getState('uid');
			return true;
		}
		else {
			$this->uid = null;
			return false;
		}
	}

	/**
	 * Returns the error info from json.
	 *
	 * @param stdClass $json the json response.
	 * @return array the error array with 2 keys: code and message. Should be null if no errors.
	 */
	protected function fetchJsonError($json) {
		if (isset($json->error)) {
			return array(
				'code' => is_string($json->error) ? 0 : $json->error->error_code,
				'message' => is_string($json->error) ? $json->error : $json->error->error_msg,
			);
		}
		else {
			return null;
		}
	}
}