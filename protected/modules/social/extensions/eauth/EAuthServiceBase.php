<?php
/**
 * EAuthServiceBase class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'IAuthService.php';

/**
 * EAuthServiceBase is a base class for providers. 
 * @package application.extensions.eauth
 */
abstract class EAuthServiceBase extends CComponent implements IAuthService {
	
	/**
	 * @var string the service name.
	 */
	protected $name;
	
	/**
	 *
	 * @var string the service title to display in views. 
	 */
	protected $title;
	
	/**
	 * @var string the service type (e.g. OpenID, OAuth).
	 */
	protected $type;
	
	/**
	 * @var array arguments for the jQuery.eauth() javascript function.
	 */
	protected $jsArguments = array();
	
	/**
	 * @var array authorization attributes.
	 * @see getAttribute
	 * @see getItem
	 */
	protected $attributes = array();
	
	/**
	 * @var boolean whether user was successfuly authenticated.
	 * @see getIsAuthenticated
	 */
	protected $authenticated = false;
	
	/**
	 * @var boolean whether is attributes was fetched.
	 */
	protected $fetched = false;
	
	/**
	 * @var EAuth the {@link EAuth} application component.
	 */
	private $component;
	
	/**
	 * @var string the redirect url after successful authorization.
	 */
	private $redirectUrl = '';
	
	/**
	 * @var string the redirect url after unsuccessful authorization (e.g. user canceled).
	 */
	private $cancelUrl = '';

	/**
	 * PHP getter magic method.
	 * This method is overridden so that service attributes can be accessed like properties.
	 * @param string $name property name.
	 * @return mixed property value.
	 * @see getAttribute
	 */
	public function __get($name) {
		if ($this->hasAttribute($name))
			return $this->getAttribute($name);
		else
			return parent::__get($name);
	}

	/**
	 * Checks if a attribute value is null.
	 * This method overrides the parent implementation by checking
	 * if the attribute is null or not.
	 * @param string $name the attribute name.
	 * @return boolean whether the attribute value is null.
	 */
	public function __isset($name) {
		if ($this->hasAttribute($name))
			return true;
		else
			return parent::__isset($name);
	}

	/**
	 * Initialize the component. 
	 * Sets the default {@link redirectUrl} and {@link cancelUrl}.
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array()) {
		if (isset($component))
			$this->setComponent($component);
	
		foreach ($options as $key => $val)
			$this->$key = $val;
		
		$this->setRedirectUrl(Yii::app()->user->returnUrl);
		$server = Yii::app()->request->getHostInfo();
		$path = Yii::app()->request->getPathInfo();
		$this->setCancelUrl($server.'/'.$path);
	}
	
	/**
	 * Returns service name(id).
	 * @return string the service name(id).
	 */
	public function getServiceName() {
		return $this->name;
	}
	
	/**
	 * Returns service title.
	 * @return string the service title.
	 */
	public function getServiceTitle() {
		return $this->title;
	}
	
	/**
	 * Returns service type (e.g. OpenID, OAuth).
	 * @return string the service type (e.g. OpenID, OAuth). 
	 */
	public function getServiceType() {
		return $this->type;
	}
		
	/**
	 * Returns arguments for the jQuery.eauth() javascript function.
	 * @return array the arguments for the jQuery.eauth() javascript function. 
	 */
	public function getJsArguments() {
		return $this->jsArguments;
	}
	
	/**
	 * Sets {@link EAuth} application component
	 * @param EAuth $component the application auth component.
	 */
	public function setComponent($component) {
		$this->component = $component;
	}
	
	/**
	 * Returns the {@link EAuth} application component.
	 * @return EAuth the {@link EAuth} application component.
	 */
	public function getComponent() {
		return $this->component;
	}
	
	/**
	 * Sets redirect url after successful authorization.
	 * @param string url to redirect.
	 */
	public function setRedirectUrl($url) {
		$this->redirectUrl = $url;
	}
	
	/**
	 * Returns the redirect url after successful authorization.
	 * @return string the redirect url after successful authorization.
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}
	
	/**
	 * Sets redirect url after unsuccessful authorization (e.g. user canceled).
	 * @param string url to redirect.
	 */
	public function setCancelUrl($url) {
		$this->cancelUrl = $url;
	}
	
	/**
	 * Returns the redirect url after unsuccessful authorization (e.g. user canceled).
	 * @return string the redirect url after unsuccessful authorization (e.g. user canceled).
	 */
	public function getCancelUrl() {
		return $this->cancelUrl;
	}
	
	/**
	 * Authenticate the user.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {		
		return $this->getIsAuthenticated();
	}
	
	/**
	 * Whether user was successfuly authenticated.
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function getIsAuthenticated() {
        return $this->authenticated;
    }
	
	/**
	 * Redirect to the url. If url is null, {@link redirectUrl} will be used.
	 * @param string $url url to redirect.
	 */
	public function redirect($url = null) {
		$this->component->redirect(isset($url) ? $url : $this->redirectUrl, true);
	}
	
	/**
	 * Redirect to the {@link cancelUrl} or simply close the popup window.
	 */
	public function cancel($url = null) {
		$this->component->redirect(isset($url) ? $url : $this->cancelUrl, false);
	}
	
	/**
	 * Makes the curl request to the url.
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return string the response.
	 */
	protected function makeRequest($url, $options = array(), $parseJson = true) {
		$ch = $this->initRequest($url, $options);
		
		if (isset($options['referer']))
			curl_setopt($ch, CURLOPT_REFERER, $options['referer']);
		
		if (isset($options['query'])) {
			$url_parts = parse_url($url);
			if (isset($url_parts['query'])) {
				$old_query = http_build_query($url_parts['query']);
				$url_parts['query'] = array_merge($url_parts['query'], $options['query']);
				$new_query = http_build_query($url_parts['query']);
				$url = str_replace($old_query, $new_query, $url);
			}
			else {
				$url_parts['query'] = $options['query'];
				$new_query = http_build_query($url_parts['query']);
				$url .= '?'.$new_query;
			}					
		}
		
		if (isset($options['data'])) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);

		$result = curl_exec($ch);
		$headers = curl_getinfo($ch);

		if (curl_errno($ch) > 0)
			throw new EAuthException(curl_error($ch), curl_errno($ch));
		
		if ($headers['http_code'] != 200)
			throw new EAuthException('Invalid response http code: '.$headers['http_code'].'.', $headers['http_code']);
			//throw new EAuthException('Unable to complete the authentication because the required data was not received.', $headers['http_code']);
		
		curl_close($ch);
				
		if ($parseJson)
			$result = $this->parseJson($result);
		
		return $result;
	}
	
	/**
	 * Initializes a new session and return a cURL handle.
	 * @param string $url url to request.
	 * @param array $options HTTP request options. Keys: query, data, referer.
	 * @param boolean $parseJson Whether to parse response in json format.
	 * @return cURL handle.
	 */
	protected function initRequest($url, $options = array()) {
		$ch = curl_init();		
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // error with open_basedir or safe mode
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		return $ch;
	}
		
	/**
	 * Parse response from {@link makeRequest} in json format and check OAuth errors.
	 * @param string $response Json string.
	 * @return object result.
	 */
	protected function parseJson($response) {
		try {
			$result = json_decode($response);
			$error = $this->fetchJsonError($result);
			if (!isset($result)) {
				throw new EAuthException('Invalid response format.', 500);
			}
			else if (isset($error)) {
				throw new EAuthException($error['message'], $error['code']);
			}
			else
				return $result;
		}
		catch(Exception $e) {
			throw new EAuthException($e->getMessage(), $e->getCode());
		}
	}
	
	/**
	 * Returns the error info from json.
	 * @param stdClass $json the json response.
	 * @return array the error array with 2 keys: code and message. Should be null if no errors.
	 */
	protected function fetchJsonError($json) {
		if (isset($json->error)) {
			return array(
				'code' => 500,
				'message' => 'Unknown error occurred.',
			);
		}
		else
			return null;
	}
	
	/**
	 * @return string a prefix for the name of the session variables storing eauth session data.
	 */
	protected function getStateKeyPrefix() {
		return '__eauth_'.$this->getServiceName().'__';
	}
	
	/**
	 * Stores a variable in eauth session.
	 * @param string $key variable name.
	 * @param mixed $value variable value.
	 * @param mixed $defaultValue default value. If $value===$defaultValue, the variable will be
	 * removed from the session.
	 * @see getState
	 */
	protected function setState($key, $value, $defaultValue = null) {
		$session = Yii::app()->session;
		$key = $this->getStateKeyPrefix().$key;
		if($value === $defaultValue)
			unset($session[$key]);
		else
			$session[$key] = $value;
	}
	
	/**
	 * Returns a value indicating whether there is a state of the specified name.
	 * @param string $key state name.
	 * @return boolean whether there is a state of the specified name.
	 */
	protected function hasState($key) {
		$session = Yii::app()->session;
		$key = $this->getStateKeyPrefix().$key;
		return isset($session[$key]);
	}
	
	/**
	 * Returns the value of a variable that is stored in eauth session.
	 * @param string $key variable name.
	 * @param mixed $defaultValue default value.
	 * @return mixed the value of the variable. If it doesn't exist in the session,
	 * the provided default value will be returned.
	 * @see setState
	 */
	protected function getState($key, $defaultValue = null) {
		$session = Yii::app()->session;
		$key = $this->getStateKeyPrefix().$key;
		return isset($session[$key]) ? $session[$key] : $defaultValue;
	}
	
	/**
	 * Fetch attributes array.
	 */
	protected function fetchAttributes() {
		
	}
	
	/**
	 * Returns the user unique id.
	 * @return mixed the user id.
	 */
	public function getId() {
		return $this->attributes['id'];
	}
	
	/**
	 * Returns the array that contains all available authorization attributes.
	 * @return array the attributes.
	 */
	public function getAttributes() {
		if (!$this->fetched) {
			$this->fetchAttributes();
			$this->fetched = true;
		}
		
		$attributes = array();
		foreach ($this->attributes as $key => $val) {
			$attributes[$key] = $this->getAttribute($key);
		}
		return $attributes;
	}
	
	/**
	 * Returns the authorization attribute value.
	 * @param string $key the attribute name.
	 * @param mixed $default the default value.
	 * @return mixed the attribute value.
	 */
	public function getAttribute($key, $default = null) {
		if (!$this->fetched) {
			$this->fetchAttributes();
			$this->fetched = true;
		}
		
		$getter = 'get'.$key;
		if (method_exists($this, $getter))
			return $this->$getter();
		else
			return isset($this->attributes[$key]) ? $this->attributes[$key] : $default;
	}
	
	/**
	 * Whether the authorization attribute exists.
	 * @param string $key the attribute name.
	 * @return boolean true if attribute exists, false otherwise.
	 */
	public function hasAttribute($key) {
		return isset($this->attributes[$key]);
	}
	
	/**
	 * Returns the object with a human-readable representation of the current authorization.
	 * @return stdClass the object.
	 */
	public function getItem() {
		$item = new stdClass;
		$item->title = $this->getAttribute('name');
		if (empty($this->title))
			$item->title = $this->getId();
		if ($this->hasAttribute('url'))
			$item->url = $this->getAttribute('url');
		return $item;
	}
		
	/**
	 * Returns the array that contains all available authorization attributes.
	 * @return array the attributes.
	 * @deprecated because getAttributes is more semantic.
	 */
	public function getItemAttributes() {
		return $this->getAttributes();
	}
}