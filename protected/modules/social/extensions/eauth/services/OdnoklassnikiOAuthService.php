<?php
/**
 * OdnoklassnikiOAuthService class file.
 *
 * Register application: http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188
 * Manage your applications: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
 * Note: Enabling this service a little more difficult because of the authorization policy of the service.
 *
 * @author Sergey Vardanyan <rakot.ss@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

/**
 * Odnoklassniki.Ru provider class.
 *
 * @package application.extensions.eauth.services
 */
class OdnoklassnikiOAuthService extends EOAuth2Service {

	protected $name = 'odnoklassniki';
	protected $title = 'Odnoklassniki';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 680, 'height' => 500));

	protected $client_id = '';
	protected $client_secret = '';
	protected $client_public = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'http://www.odnoklassniki.ru/oauth/authorize',
		'access_token' => 'http://api.odnoklassniki.ru/oauth/token.do',
	);

	protected function fetchAttributes() {

		$info = $this->makeSignedRequest('http://api.odnoklassniki.ru/fb.do', array(
			'query' => array(
				'method' => 'users.getCurrentUser',
				'format' => 'JSON',
				'application_key' => $this->client_public,
				'client_id' => $this->client_id,
			),
		));

		$this->attributes['id'] = $info->uid;
		$this->attributes['name'] = $info->first_name . ' ' . $info->last_name;
	}

	protected function getTokenUrl($code) {
		return $this->providerOptions['access_token'];
	}

	protected function getAccessToken($code) {
		$params = array(
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'grant_type' => 'authorization_code',
			'code' => $code,
			'redirect_uri' => $this->getState('redirect_uri'),
		);
		$result = $this->makeRequest($this->getTokenUrl($code), array('data' => $params, 'query' => $params));
		return $result->access_token;
	}

	protected function getCodeUrl($redirect_uri) {
		$this->setState('redirect_uri', $redirect_uri);
		$url = parent::getCodeUrl($redirect_uri);
		if (isset($_GET['js'])) {
			$url .= '&display=popup';
		}
		return $url;
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
				'code' => $json->error_code,
				'message' => $json->error_description,
			);
		}
		else {
			return null;
		}
	}

	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated()) {
			throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => $this->getServiceTitle())));
		}

		$_params = '';
		ksort($options['query']);
		foreach ($options['query'] as $k => $v)
			$_params .= $k . '=' . $v;
		$options['query']['sig'] = md5($_params . md5($this->access_token . $this->client_secret));
		$options['query']['access_token'] = $this->access_token;

		$result = $this->makeRequest($url, $options);
		return $result;
	}

}
