<?php
/**
 * EOpenIDService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOpenIDService is a base class for all OpenID providers.
 *
 * @package application.extensions.eauth
 */
abstract class EOpenIDService extends EAuthServiceBase implements IAuthService {

	/**
	 * @var string a pattern that represents the part of URL-space for which an OpenID Authentication request is valid.
	 * See the spec for more info: http://openid.net/specs/openid-authentication-2_0.html#realms
	 * Note: a pattern can be without http(s):// part
	 */
	public $realm;

	/**
	 * @var EOpenID the openid library instance.
	 */
	private $auth;

	/**
	 * @var string the OpenID authorization url.
	 */
	protected $url;

	/**
	 * @var array the OpenID required attributes.
	 */
	protected $requiredAttributes = array();

	/**
	 * @var array the OpenID optional attributes.
	 */
	protected $optionalAttributes = array();


	/**
	 * Initialize the component.
	 *
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array()) {
		parent::init($component, $options);
		$this->auth = Yii::app()->loid->load();
		//$this->auth = new EOpenID();
	}

	/**
	 * Authenticate the user.
	 *
	 * @return boolean whether user was successfuly authenticated.
	 * @throws EAuthException
	 * @throws CHttpException
	 */
	public function authenticate() {
		if (!empty($_REQUEST['openid_mode'])) {
			switch ($_REQUEST['openid_mode']) {
				case 'id_res':
					try {
						if ($this->auth->validate()) {
							$this->attributes['id'] = $this->auth->identity;

							$attributes = $this->auth->getAttributes();
							foreach ($this->requiredAttributes as $key => $attr) {
								if (isset($attributes[$attr[1]])) {
									$this->attributes[$key] = $attributes[$attr[1]];
								}
								else {
									throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => $this->getServiceTitle())));
									return false;
								}
							}

							foreach ($this->optionalAttributes as $key => $attr) {
								if (isset($attributes[$attr[1]])) {
									$this->attributes[$key] = $attributes[$attr[1]];
								}
							}

							$this->authenticated = true;
							return true;
						}
						else {
							throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => $this->getServiceTitle())));
							return false;
						}
					} catch (Exception $e) {
						throw new EAuthException($e->getMessage(), $e->getCode());
					}
					break;

				case 'cancel':
					$this->cancel();
					break;

				default:
					throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
					break;
			}
		}
		else {
			$this->auth->identity = $this->url; //Setting identifier
			$this->auth->required = array(); //Try to get info from openid provider
			foreach ($this->requiredAttributes as $attribute) {
				$this->auth->required[$attribute[0]] = $attribute[1];
			}
			foreach ($this->optionalAttributes as $attribute) {
				$this->auth->required[$attribute[0]] = $attribute[1];
			}

			if (isset($this->realm)) {
				if (!preg_match('#^[a-z]+\://#', $this->realm)) {
					$this->auth->realm = 'http' . (Yii::app()->request->getIsSecureConnection() ? 's' : '') . '://' . $this->realm;
				}
				else {
					$this->auth->realm = $this->realm;
				}
			}
			else {
				$this->auth->realm = Yii::app()->request->hostInfo;
			}

			$this->auth->returnUrl = Yii::app()->request->hostInfo . Yii::app()->request->url; //getting return URL


			try {
				$url = $this->auth->authUrl();
				Yii::app()->request->redirect($url);
			} catch (Exception $e) {
				throw new EAuthException($e->getMessage(), $e->getCode());
			}
		}

		return false;
	}
}