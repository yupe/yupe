<?php
/**
 * EOAuth2Service class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOAuth2Service is a base class for all OAuth 2.0 providers.
 *
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
	 * @var string Error key name in _GET options.
	 */
	protected $errorParam = 'error';

	/**
	 * @var string Error description key name in _GET options.
	 */
	protected $errorDescriptionParam = 'error_description';

	/**
	 * @var string Error code for access_denied response.
	 */
	protected $errorAccessDeniedCode = 'access_denied';


	/**
	 * Authenticate the user.
	 *
	 * @return boolean whether user was successfuly authenticated.
	 * @throws EAuthException
	 */
	public function authenticate() {
		if (isset($_GET[$this->errorParam])) {
			$error_code = $_GET[$this->errorParam];
			if ($error_code === $this->errorAccessDeniedCode) {
				// access_denied error (user canceled)
				$this->cancel();
			}
			else {
				$error = $error_code;
				if (isset($_GET[$this->errorDescriptionParam])) {
					$error = $_GET[$this->errorDescriptionParam].' ('.$error.')';
				}
				throw new EAuthException($error);
			}
			return false;
		}

		// Get the access_token and save them to the session.
		if (isset($_GET['code'])) {
			$code = $_GET['code'];
			$token = $this->getAccessToken($code);
			if (isset($token)) {
				$this->saveAccessToken($token);
				$this->authenticated = true;
			}
		}
		// Redirect to the authorization page
		else {
			if (!$this->restoreAccessToken()) {
				// Use the URL of the current page as the callback URL.
				if (isset($_GET['redirect_uri'])) {
					$redirect_uri = $_GET['redirect_uri'];
				}
				else {
					$server = Yii::app()->request->getHostInfo();
					$path = Yii::app()->request->getUrl();
					$redirect_uri = $server . $path;
				}
				$url = $this->getCodeUrl($redirect_uri);
				Yii::app()->request->redirect($url);
			}
		}

		return $this->getIsAuthenticated();
	}

	/**
	 * Returns the url to request to get OAuth2 code.
	 *
	 * @param string $redirect_uri url to redirect after user confirmation.
	 * @return string url to request.
	 */
	protected function getCodeUrl($redirect_uri) {
		$this->setState('redirect_uri', $redirect_uri);
		return $this->providerOptions['authorize'] . '?client_id=' . $this->client_id . '&redirect_uri=' . urlencode($redirect_uri) . '&scope=' . $this->scope . '&response_type=code';
	}

	/**
	 * Returns the url to request to get OAuth2 access token.
	 *
	 * @param string $code
	 * @return string url to request.
	 */
	protected function getTokenUrl($code) {
		return $this->providerOptions['access_token'] . '?client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&code=' . $code . '&redirect_uri=' . urlencode($this->getState('redirect_uri'));
	}

	/**
	 * Returns the OAuth2 access token.
	 *
	 * @param string $code the OAuth2 code. See {@link getCodeUrl}.
	 * @return string the token.
	 */
	protected function getAccessToken($code) {
		return $this->makeRequest($this->getTokenUrl($code));
	}

	/**
	 * Save access token to the session.
	 *
	 * @param string $token access token.
	 */
	protected function saveAccessToken($token) {
		$this->setState('auth_token', $token);
		$this->access_token = $token;
	}

	/**
	 * Restore access token from the session.
	 *
	 * @return boolean whether the access token was successfuly restored.
	 */
	protected function restoreAccessToken() {
		if ($this->hasState('auth_token') && $this->getState('expires', 0) > time()) {
			$this->access_token = $this->getState('auth_token');
			$this->authenticated = true;
			return true;
		}
		else {
			$this->access_token = null;
			$this->authenticated = false;
			return false;
		}
	}

	/**
	 * Returns the protected resource.
	 *
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return stdClass the response.
	 * @see makeRequest
	 */
	public function makeSignedRequest($url, $options = array(), $parseJson = true) {
		if (!$this->getIsAuthenticated()) {
			throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the request because the user was not authenticated.'));
		}

		$options['query']['access_token'] = $this->access_token;
		$result = $this->makeRequest($url, $options);
		return $result;
	}
}
