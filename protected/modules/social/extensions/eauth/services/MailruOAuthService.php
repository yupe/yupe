<?php
/**
 * MailRuOAuthService class file.
 *
 * @author ChooJoy <choojoy.work@gmail.com>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

/**
 * Mail.Ru provider class.
 * @package application.extensions.eauth.services
 */
class MailruOAuthService extends EOAuth2Service {	
	
	protected $name = 'mailru';
	protected $title = 'Mail.ru';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 580, 'height' => 400));

	protected $client_id = '';
	protected $client_secret = '';
	protected $scope = '';
	protected $providerOptions = array(
		'authorize' => 'https://connect.mail.ru/oauth/authorize',
		'access_token' => 'https://connect.mail.ru/oauth/token',
	);
		
	protected function fetchAttributes() {
		$info = (array)$this->makeSignedRequest('http://www.appsmail.ru/platform/api', array(
			'query' => array(
				'uids' => $this->getUid(),
				'method' => 'users.getInfo',
				'app_id' => $this->client_id,
			),
		));
		
		$info = $info[0];
				
		$this->attributes['id'] = $info->uid;
		$this->attributes['name'] = $info->first_name.' '.$info->last_name;
		$this->attributes['url'] = $info->link;
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
		$result = $this->makeRequest($this->getTokenUrl($code), array('data' => $params));
		$this->setState('uid', $result->x_mailru_vid);
		return $result->access_token;
	}
	
	protected function getCodeUrl($redirect_uri) {
		$this->setState('redirect_uri', $redirect_uri);
		$url = parent::getCodeUrl($redirect_uri);
		if (isset($_GET['js']))
			$url .= '&display=popup';
		
		return $url;
	}
		
	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated())
				throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => ucfirst($this->serviceName))));
	
		$options['query']['secure'] = 1;
		$options['query']['session_key'] = $this->access_token;
		$_params = '';
		ksort($options['query']);
		foreach ($options['query'] as $k => $v) 
			$_params .= $k . '=' . $v;
		$options['query']['sig'] = md5($_params . $this->client_secret);
		
		$result = $this->makeRequest($url, $options);
		return $result;
	}
	
	protected function getUid() {
		if (!$this->hasState('uid'))
			throw new EAuthException('Unable to get mailru user id.', 500);
		return $this->getState('uid');
	}
	
	/**
	 * Returns the error info from json.
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
		else
			return null;
	}
}