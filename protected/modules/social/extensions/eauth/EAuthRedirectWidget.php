<?php
/**
 * EAuthRedirectWidget class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://code.google.com/p/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * The EAuthRedirectWidget widget displays the redirect page after returning from provider.
 * @package application.extensions.eauth
 */
class EAuthRedirectWidget extends CWidget {
		
	/**
	 * @var mixed the widget mode. Default to "login".
	 */
	public $url = null;
	
	/**
	 * @var boolean whether to use redirect inside the popup window.
	 */
	public $redirect = true;
	
	/**
	 * Executes the widget.
	 */
    public function run() {
		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$this->render('redirect', array(
			'id' => $this->getId(),
			'url' => $this->url,
			'redirect' => $this->redirect,
			'assets_path' => $assets_path,
		));
		Yii::app()->end();
    }
}
