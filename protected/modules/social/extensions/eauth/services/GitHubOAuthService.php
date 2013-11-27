<?php
/**
 * GitHubOAuthService class file.
 *
 * Register application: https://github.com/settings/applications
 *
 * @author Alexander Shkarpetin <ashkarpetin@gmail.com>
 * @link https://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

/**
 * GitHub provider class.
 *
 * @package application.extensions.eauth.services
 */
class GitHubOAuthService extends EOAuth2Service {

	protected $name = 'github';
	protected $title = 'GitHub';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 450));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://github.com/login/oauth/authorize',
		'access_token' => 'https://github.com/login/oauth/access_token',
	);

	protected $errorAccessDeniedCode = 'user_denied';

	protected function fetchAttributes() {
		$info = (object)$this->makeSignedRequest('https://api.github.com/user');

		$this->attributes['id'] = $info->id;
		$this->attributes['name'] = $info->login;
		$this->attributes['url'] = $info->html_url;
	}

	protected function getTokenUrl($code) {
		return $this->providerOptions['access_token'];
	}

	protected function getAccessToken($code) {
		$params = array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'code' => $code,
		);

		$response = $this->makeRequest($this->getTokenUrl($code), array('data' => $params), false);
		parse_str($response, $result);
		return $result['access_token'];
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
				'code' => $json->error->code,
				'message' => $json->error->message,
			);
		}
		else {
			return null;
		}
	}

	/**
	 * Add User-Agent header
	 *
	 * @param string $url
	 * @param array $options
	 * @return cURL
	 */
	protected function initRequest($url, $options = array()) {
		$ch = parent::initRequest($url, $options);
		curl_setopt($ch, CURLOPT_USERAGENT, 'yii-eauth extension');
		return $ch;
	}
}