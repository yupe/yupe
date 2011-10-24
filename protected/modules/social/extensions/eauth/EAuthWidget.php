<?php
/**
 * EAuthWidget class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * The EAuthWidget widget prints buttons to authenticate user with OpenID and OAuth providers.
 * @package application.extensions.eauth
 */
class EAuthWidget extends CWidget {
		
	/**
	 * @var mixed the widget mode. Default to "login".
	 */
	public $mode = 'login';
	
	/**
	 * @var array the services.
	 * @see EAuth::getServices() 
	 */
	public $services = array();
	
	/**
	 * @var string the action to use for dialog destination.
	 */
	public $action = 'site/login';
	
	/**
	 * @var boolean whether to use popup window for authorization dialog. Javascript required.
	 */
	public $popup = true;
	
	/**
	 * Executes the widget.
	 */
    public function run() {
		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		
		$this->render('auth', array(
			'id' => $this->getId(),
			'services' => $this->services,
			'mode' => $this->mode,
			'action' => $this->action,
			'popup' => $this->popup,
			'assets_path' => $assets_path,
		));
    }
}
