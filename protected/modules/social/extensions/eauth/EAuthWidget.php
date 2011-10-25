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
	 * @var string EAuth component name.
	 */
	public $component = 'eauth';
	
	/**
	 * @var array the services.
	 * @see EAuth::getServices() 
	 */
	public $services = null;
	
	/**
	 * @var boolean whether to use popup window for authorization dialog. Javascript required.
	 */
	public $popup = null;
	
	/**
	 * @var string the action to use for dialog destination. Default: the current route.
	 */
	public $action = null;
		
	/**
	 * Executes the widget.
	 */
    public function run() {
		// EAuth component
		$component = Yii::app()->{$this->component};
		
		// Some default properties from component configuration
		if (!isset($this->services))
			$this->services = $component->getServices();
		if (!isset($this->popup))
			$this->popup = $component->popup;
		
		// Set the current route, if it is not set.
		if (!isset($this->action))
			$this->action = Yii::app()->urlManager->parseUrl(Yii::app()->request);
		
		$this->registerAssets();
		$this->render('auth', array(
			'id' => $this->getId(),
			'services' => $this->services,
			'action' => $this->action,
		));
    }
	
	/**
	 * Register CSS and JS files.
	 */
	protected function registerAssets() {
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');

		$assets_path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
		$cs->registerCssFile($url.'/css/auth.css');

		// Open the authorization dilalog in popup window.
		if ($this->popup) {
			$cs->registerScriptFile($url.'/js/auth.js', CClientScript::POS_HEAD);
			$js = '';
			foreach ($this->services as $name => $service) {
				$args = $service->jsArguments;
				$args['id'] = $service->id;
				$js .= '$(".auth-service.'.$service->id.' a").eauth('.json_encode($args).');'."\n";
			}
			$cs->registerScript('eauth-services', $js, CClientScript::POS_READY);
		}
	}
}
