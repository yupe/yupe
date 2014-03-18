<?php
/**
 * EAuth class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * The EAuth class provides simple authentication via OpenID and OAuth providers.
 *
 * @package application.extensions.eauth
 */
class EAuth extends CApplicationComponent {

	/**
	 * @var array Authorization services and their settings.
	 */
	public $services = array();

	/**
	 * @var boolean Whether to use popup window for the authorization dialog.
	 */
	public $popup = true;

	/**
	 * @var mixed Cache component name to use. False to disable cache.
	 */
	public $cache = 'cache';

	/**
	 * @var integer the number of seconds in which the cached value will expire. 0 means never expire.
	 */
	public $cacheExpire = 0;

	/**
	 * @var string popup redirect view with custom js code
	 */
	protected $redirectView = 'redirect';

	/**
	 * Returns services settings declared in the authorization classes.
	 * For perfomance reasons it uses cache to store settings array.
	 *
	 * @return array services settings.
	 */
	public function getServices() {
		$services = false;
		if (!empty($this->cache) && Yii::app()->hasComponent($this->cache)) {
			$cache = Yii::app()->getComponent($this->cache);
			$services = $cache->get('EAuth.services');
		}

		if (false === $services || !is_array($services)) {
			$services = array();
			foreach ($this->services as $service => $options) {
				$class = $this->getIdentity($service);
				$services[$service] = (object)array(
					'id' => $class->getServiceName(),
					'title' => $class->getServiceTitle(),
					'type' => $class->getServiceType(),
					'jsArguments' => $class->getJsArguments(),
				);
			}
			if (isset($cache)) {
				$cache->set('EAuth.services', $services, $this->cacheExpire);
			}
		}
		return $services;
	}

	/**
	 * Returns the settings of the service.
	 *
	 * @param string $service the service name.
	 * @return array the service settings.
	 */
	protected function getService($service) {
		$service = strtolower($service);
		$services = $this->getServices();
		if (!isset($services[$service])) {
			throw new EAuthException(Yii::t('eauth', 'Undefined service name: {service}.', array('{service}' => $service)), 500);
		}
		return $services[$service];
	}

	/**
	 * Returns the type of the service.
	 *
	 * @param string $service the service name.
	 * @return string the service type.
	 */
	public function getServiceType($service) {
		$service = $this->getService($service);
		return $service->type;
	}

	/**
	 * Returns the service identity class.
	 *
	 * @param string $service the service name.
	 * @return IAuthService the identity class.
	 */
	public function getIdentity($service) {
		$service = strtolower($service);
		if (!isset($this->services[$service])) {
			throw new EAuthException(Yii::t('eauth', 'Undefined service name: {service}.', array('{service}' => $service)), 500);
		}
		$service = $this->services[$service];

		$class = $service['class'];
		$point = strrpos($class, '.');
		// if it is yii path alias
		if ($point > 0) {
			Yii::import($class);
			$class = substr($class, $point + 1);
		}
		unset($service['class']);
		$identity = new $class();
		$identity->init($this, $service);
		return $identity;
	}

	/**
	 * Change default redirect view to custom. Allow Yii alias.
	 *
	 * @param string $view new name of view with js code
	 */
	public function setRedirectView($view) {
		$this->redirectView = $view;
	}

	/**
	 * Redirects to url. If the authorization dialog opened in the popup window,
	 * it will be closed instead of redirect. Set $jsRedirect=true if you want
	 * to redirect anyway.
	 *
	 * @param mixed $url url to redirect. Can be route or normal url. See {@link CHtml::normalizeUrl}.
	 * @param boolean $jsRedirect whether to use redirect while popup window is used. Defaults to true.
	 * @param array $params
	 */
	public function redirect($url, $jsRedirect = true, $params = array()) {
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'EAuthRedirectWidget.php';
		$widget = Yii::app()->getWidgetFactory()->createWidget($this, 'EAuthRedirectWidget',
			array(
				'url' => CHtml::normalizeUrl($url),
				'redirect' => $jsRedirect,
				'view' => $this->redirectView,
				'params' => $params
			)
		);
		$widget->init();
		$widget->run();
	}

	/**
	 * Simple wrapper for {@link CController::widget} function for render the {@link EAuthWidget} widget.
	 *
	 * @param array $properties the widget properties.
	 * @deprecated use CComponent->widget('ext.eauth.EAuthWidget', $properties) instead.
	 */
	public function renderWidget($properties = array()) {
		require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'EAuthWidget.php';
		$widget = Yii::app()->getWidgetFactory()->createWidget($this, 'EAuthWidget', $properties);
		$widget->init();
		$widget->run();
	}

	/**
	 * Serialize the identity class.
	 *
	 * @param EAuthServiceBase $identity the class instance.
	 * @return string serialized value.
	 */
	public function toString($identity) {
		return serialize($identity);
	}

	/**
	 * Serialize the identity class.
	 *
	 * @param string $identity serialized value.
	 * @return EAuthServiceBase the class instance.
	 */
	public function fromString($identity) {
		return unserialize($identity);
	}
}

/**
 * The EAuthException exception class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @package application.extensions.auth
 * @version 1.0
 */
class EAuthException extends CException {
}
