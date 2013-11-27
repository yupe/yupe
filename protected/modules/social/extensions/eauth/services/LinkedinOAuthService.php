<?php
/**
 * LinkedinOAuthService class file.
 *
 * Register application: https://www.linkedin.com/secure/developer
 * Note: Intagration URL should be filled with a valid callback url.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/EOAuthService.php';

/**
 * LinkedIn provider class.
 *
 * @package application.extensions.eauth.services
 */
class LinkedinOAuthService extends EOAuthService {

	protected $name = 'linkedin';
	protected $title = 'LinkedIn';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $key = '';
	protected $secret = '';
	protected $scope = 'r_basicprofile'; // 'r_fullprofile r_emailaddress';
	protected $providerOptions = array(
		'request' => 'https://api.linkedin.com/uas/oauth/requestToken',
		'authorize' => 'https://www.linkedin.com/uas/oauth/authenticate', // https://www.linkedin.com/uas/oauth/authorize
		'access' => 'https://api.linkedin.com/uas/oauth/accessToken',
	);

	protected function fetchAttributes() {
		$info = $this->makeSignedRequest('http://api.linkedin.com/v1/people/~:(id,first-name,last-name,public-profile-url)', array(), false); // json format not working :(
		$info = $this->parseInfo($info);

		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['first-name'] . ' ' . $info['last-name'];
		$this->attributes['url'] = $info['public-profile-url'];
	}

	/**
	 *
	 * @param string $xml
	 * @return array
	 */
	protected function parseInfo($xml) {
		/* @var $simplexml SimpleXMLElement */
		$simplexml = simplexml_load_string($xml);
		return $this->xmlToArray($simplexml);
	}

	/**
	 *
	 * @param SimpleXMLElement $element
	 * @return array
	 */
	protected function xmlToArray($element) {
		$array = (array)$element;
		foreach ($array as $key => $value) {
			if (is_object($value)) {
				$array[$key] = $this->xmlToArray($value);
			}
		}
		return $array;
	}
}