<?php
/**
 * MoikrugOAuthService class file.
 *
 * Register application: https://oauth.yandex.ru/client/my
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

/**
 * Moikrug provider class.
 *
 * @package application.extensions.eauth.services
 */
class MoikrugOAuthService extends EOAuth2Service {

	protected $name = 'moikrug';
	protected $title = 'Moikrug.ru';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://oauth.yandex.ru/authorize',
		'access_token' => 'https://oauth.yandex.ru/token',
	);
	protected $fields = '';

	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('https://api.moikrug.ru/v1/my/');
		$info = (array)$info[0];
		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['name'];
		$this->attributes['url'] = $info['link'];
		//$this->attributes['photo'] = $info['avatar']['SnippetSquare'];
		$this->attributes['gender'] = ($info['gender'] == 'male') ? 'M' : 'F';
	}

	protected function getCodeUrl($redirect_uri) {
		$url = parent::getCodeUrl($redirect_uri);
		if (isset($_GET['js'])) {
			$url .= '&display=popup';
		}
		return $url;
	}

	protected function getTokenUrl($code) {
		return $this->providerOptions['access_token'];
	}

	protected function getAccessToken($code) {
		$params = array(
			'grant_type' => 'authorization_code',
			'code' => $code,
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
		);
		return $this->makeRequest($this->getTokenUrl($code), array('data' => $params));
	}

	/**
	 * Save access token to the session.
	 *
	 * @param stdClass $token access token array.
	 */
	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token->access_token);
		$this->setState('expires', time() + (isset($token->expires_in) ? $token->expires_in : 365 * 86400) - 60);
		$this->access_token = $token->access_token;
	}

	/**
	 * Returns the protected resource.
	 *
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return string the response.
	 * @see makeRequest
	 */
	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated()) {
			throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => $this->getServiceTitle())));
		}

		$options['query']['oauth_token'] = $this->access_token;
		$result = $this->makeRequest($url, $options);
		return $result;
	}
}