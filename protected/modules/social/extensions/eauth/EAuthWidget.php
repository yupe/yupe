<?php
/**
 * EAuthWidget class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * The EAuthWidget widget prints buttons to authenticate user with OpenID and OAuth providers.
 *
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
	 * @var array predefined services. If null then use all services. Default is null.
	 */
	public $predefinedServices = null;

	/**
	 * @var boolean whether to use popup window for authorization dialog. Javascript required.
	 */
	public $popup = null;

	/**
	 * @var string the action to use for dialog destination. Default: the current route.
	 */
	public $action = null;

	/**
	 * @var boolean include the CSS file. Default is true.
	 * If this is set false, you are responsible to explicitly include the necessary CSS file in your page.
	 */
	public $cssFile = true;

	/**
	 * Initializes the widget.
	 * This method is called by {@link CBaseController::createWidget}
	 * and {@link CBaseController::beginWidget} after the widget's
	 * properties have been initialized.
	 */
	public function init() {
		parent::init();

		// EAuth component
		$component = Yii::app()->getComponent($this->component);

		// Some default properties from component configuration
		if (!isset($this->services)) {
			$this->services = $component->getServices();
		}

		if (is_array($this->predefinedServices)) {
			$_services = array();
			foreach ($this->predefinedServices as $_serviceName) {
				if (isset($this->services[$_serviceName])) {
					$_services[$_serviceName] = $this->services[$_serviceName];
				}
			}
			$this->services = $_services;
		}

		if (!isset($this->popup)) {
			$this->popup = $component->popup;
		}

		// Set the current route, if it is not set.
		if (!isset($this->action)) {
			$this->action = Yii::app()->urlManager->parseUrl(Yii::app()->request);
		}
	}

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run() {
		parent::run();

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

		$assets_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
		if ($this->cssFile) $cs->registerCssFile($url . '/css/auth.css');

		// Open the authorization dilalog in popup window.
		if ($this->popup) {
			$cs->registerScriptFile($url . '/js/auth.js', CClientScript::POS_END);
			$js = '';
			foreach ($this->services as $name => $service) {
				$args = $service->jsArguments;
				$args['id'] = $service->id;
				$js .= '$(".auth-service.' . $service->id . ' a").eauth(' . json_encode($args) . ');' . "\n";
			}
			$cs->registerScript('eauth-services', $js, CClientScript::POS_READY);
		}
	}
}
