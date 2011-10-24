<?php
/**
 * EOpenIDService class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once 'EAuthServiceBase.php';

/**
 * EOpenIDService is a base class for all OpenID providers.
 * @package application.extensions.eauth
 */
abstract class EOpenIDService extends EAuthServiceBase implements IAuthService {
	
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
	 * Initialize the component.
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
	 * @return boolean whether user was successfuly authenticated.
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
									throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => ucfirst($this->getServiceName()))));
									return false;
								}
							}

							$this->authenticated = true;
							return true;
						}
						else {
							throw new EAuthException(Yii::t('eauth', 'Unable to complete the authentication because the required data was not received.', array('{provider}' => ucfirst($this->getServiceName()))));
							return false;
						}
					}
					catch (Exception $e) {
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
			foreach ($this->requiredAttributes as $attribute)
				$this->auth->required[$attribute[0]] = $attribute[1];
			$this->auth->realm = Yii::app()->request->hostInfo;
			$this->auth->returnUrl = $this->auth->realm.Yii::app()->request->url; //getting return URL
						
			try {
				$url = $this->auth->authUrl();
				Yii::app()->request->redirect($url);
			}
			catch (Exception $e) {
				throw new EAuthException($e->getMessage(), $e->getCode());
			}
		}
				
		return false;
	}
}