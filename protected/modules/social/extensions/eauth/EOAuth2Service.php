<?php
/**
 * EOAuth2Service class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOAuth2Service is a base class for all OAuth 2.0 providers.
 * @package application.extensions.eauth
 */
abstract class EOAuth2Service extends EAuthServiceBase implements IAuthService {

	/**
	 * @var string OAuth2 client id. 
	 */
	protected $client_id;
	
	/**
	 * @var string OAuth2 client secret key.
	 */
	protected $client_secret;
	
	/**
	 * @var string OAuth scopes. 
	 */
	protected $scope = '';
	
	/**
	 * @var array Provider options. Must contain the keys: authorize, access_token.
	 */
	protected $providerOptions = array(
		'authorize' => '',
		'access_token' => '',
	);
	
	/**
	 * @var string current OAuth2 access token.
	 */
	protected $access_token = '';
	
		
	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {
		// user denied error
		if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
			$this->cancel();
			return false;
		}
		
		//Получаем "access_token" и сохр. в сессионной переменной
		if (isset($_GET['code'])) {
            $code = $_GET['code'];
			$token = $this->getAccessToken($code);
			if (isset($token)) {
				$this->setState('auth_token', $token);
				$this->access_token = $token;
				$this->authenticated = true;
			}
        }
		//Получаем "code"
		else if (!$this->hasState('auth_token')) {
			// Use the URL of the current page as the callback URL.
			$server = Yii::app()->request->getHostInfo();
			$path = Yii::app()->request->getUrl();
			$url = $this->getCodeUrl($server.$path);
			Yii::app()->request->redirect($url);
		}
		else { 	
			$this->access_token = $this->getState('auth_token');
			$this->authenticated = true;
		}
		
		return $this->getIsAuthenticated();
	}
	
	/**
	 * Returns the url to request to get OAuth2 code.
	 * @param string $redirect_uri url to redirect after user confirmation.
	 * @return string url to request. 
	 */
	protected function getCodeUrl($redirect_uri) {
		return $this->providerOptions['authorize'].'?client_id='.$this->client_id.'&redirect_uri='.urlencode($redirect_uri).'&scope='.$this->scope.'&response_type=code';
	}
	
	/**
	 * Returns the url to request to get OAuth2 access token.
	 * @return string url to request. 
	 */
	protected function getTokenUrl($code) {
		return $this->providerOptions['access_token'].'?client_id='.$this->client_id.'&client_secret='.$this->client_secret.'&code='.$code;
	}

	/**
	 * Returns the OAuth2 access token.
	 * @param string $code the OAuth2 code. See {@link getCodeUrl}.
	 * @return string the token.
	 */
	protected function getAccessToken($code) {
		return $this->makeRequest($this->getTokenUrl($code));
	}
	
	/**
	 * Returns the protected resource.
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return string the response. 
	 * @see makeRequest
	 */
	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated())
			throw new CHttpException(401, 'Unable to complete the authentication because the required data was not received.');
		
		$options['query']['access_token'] = $this->access_token;
		$result = $this->makeRequest($url, $options);
		return $result;
	}
}