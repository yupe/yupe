<?php
/**
 * Yandex OAuth class with "state" field support. 
 * See https://github.com/Nodge/yii-eauth/pull/21 for more details.
 *
 * @author errRust https://github.com/errRust
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/services/YandexOauthService.php';

class CustomYandexOAuthService extends YandexOAuthService {

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
		else if (!$this->restoreAccessToken()) {
			// Use the URL of the current page as the callback URL.
			if (isset($_GET['redirect_uri'])) {
				$redirect_uri = $_GET['redirect_uri'];
			}
			else {
				$server = Yii::app()->request->getHostInfo();
				$path = Yii::app()->request->getUrl();
				$redirect_uri = $server.$path;
			}

			$url = $this->getCodeUrl($redirect_uri, $_GET['state']);
			Yii::app()->request->redirect($url);
		}

		return $this->getIsAuthenticated();
	}

	protected function getCodeUrl($redirect_uri, $state) {
		return $this->providerOptions['authorize'].'?client_id='.$this->client_id.'&redirect_uri='.urlencode($redirect_uri).'&scope='.$this->scope.'&response_type=code&state='.urlencode($state);
	}

	protected function fetchAttributes() {
		$info = (array) $this->makeSignedRequest('https://login.yandex.ru/info');

		// COMPOSING UNIFIED ATTRIBUTES FOR STORING IN DATABASE
		$this->attributes['service'] = $this->name;
		$this->attributes['access_token'] = $this->access_token;

		$this->attributes['id'] = $info['id'];
		$this->attributes['identifier'] = $info['id'];
		$this->attributes['fullname'] = $info['real_name'];
		$this->attributes['nickname'] = $info['display_name'];
		$this->attributes['email'] = $info['default_email'];
		$this->attributes['sex'] = ($info['sex'] == 'male') ? 'm' : 'f';
		$this->attributes['birth_dt']=$info['birthday'];
	}

}
