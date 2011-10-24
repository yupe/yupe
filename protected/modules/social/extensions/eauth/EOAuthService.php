<?php
/**
 * EOAuthService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOAuthService is a base class for all OAuth providers.
 * @package application.extensions.eauth
 */
abstract class EOAuthService extends EAuthServiceBase implements IAuthService {
	
	/**
	 * @var EOAuthUserIdentity the OAuth library instance.
	 */
	private $auth;
	
		
	/**
	 * @var string OAuth2 client id. 
	 */
	protected $key;
	
	/**
	 * @var string OAuth2 client secret key.
	 */
	protected $secret;
	
	/**
	 * @var string OAuth scopes. 
	 */
	protected $scope = '';
	
	/**
	 * @var array Provider options. Must contain the keys: request, authorize, access.
	 */
	protected $providerOptions =  array(
		'request' => '',
		'authorize' => '',
		'access' => '',
	);
	
	
	/**
	 * Initialize the component.
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array()) {		
		parent::init($component, $options);
		
		$this->auth = new EOAuthUserIdentity(array(
			'scope' => $this->scope,
			'key' => $this->key,
			'secret' => $this->secret,
			'provider' => $this->providerOptions,
		));
	}
	
	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {
		$this->authenticated = $this->auth->authenticate();
		return $this->getIsAuthenticated();
	}
	
	/**
	 * Returns the OAuth consumer.
	 * @return object the consumer.
	 */
	protected function getConsumer() {
		return $this->auth->getProvider()->consumer;
	}
	
	/**
	 * Returns the OAuth access token.
	 * @return string the token.
	 */
	protected function getAccessToken() {
		return $this->auth->getProvider()->token;
	}
	
	/**
	 * Initializes a new session and return a cURL handle.
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return cURL handle.
	 */
	protected function initRequest($url, $options = array()) {
		$ch = parent::initRequest($url, $options);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		if (isset($params['data'])) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml","SOAPAction: \"/soap/action/query\"", "Content-length: ".strlen($data))); 
		}
		return $ch;
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
						
		$consumer = $this->getConsumer();
		$signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
		$token = $this->getAccessToken();

		$request = OAuthRequest::from_consumer_and_token($consumer, $token, isset($options['data']) ? 'POST' : 'GET', $url);
		$request->sign_request($signatureMethod, $consumer, $token);
		$url = $request->to_url();
		
		return $this->makeRequest($url, $options, $parseJson);
	}
}