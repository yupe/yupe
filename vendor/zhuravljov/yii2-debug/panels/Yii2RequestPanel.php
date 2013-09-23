<?php

/**
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 * @package Yii2Debug
 * @since 1.1.13
 */
class Yii2RequestPanel extends Yii2DebugPanel
{
	public function getName()
	{
		return 'Request';
	}

	public function getSummary()
	{
		return $this->render(dirname(__FILE__) . '/../views/panels/request_bar.php');
	}

	public function getDetail()
	{
		return $this->render(dirname(__FILE__) . '/../views/panels/request.php');
	}

	public function save()
	{
		if (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
		} elseif (function_exists('http_get_request_headers')) {
			$requestHeaders = http_get_request_headers();
		} else {
			$requestHeaders = array();
		}
		$responseHeaders = array();
		foreach (headers_list() as $header) {
			if (($pos = strpos($header, ':')) !== false) {
				$name = substr($header, 0, $pos);
				$value = trim(substr($header, $pos + 1));
				if (isset($responseHeaders[$name])) {
					if (!is_array($responseHeaders[$name])) {
						$responseHeaders[$name] = array($responseHeaders[$name], $value);
					} else {
						$responseHeaders[$name][] = $value;
					}
				} else {
					$responseHeaders[$name] = $value;
				}
			} else {
				$responseHeaders[] = $header;
			}
		}

		$route = Yii::app()->getUrlManager()->parseUrl(Yii::app()->getRequest());
		$action = null;
		$actionParams = array();
		if (($ca = @Yii::app()->createController($route)) !== null) {
			/* @var CController $controller */
			/* @var string $actionID */
			list($controller, $actionID) = $ca;
			if (!$actionID) $actionID = $controller->defaultAction;
			if (($a = $controller->createAction($actionID)) !== null) {
				if ($a instanceof CInlineAction) {
					$action = get_class($controller) . '::action' . ucfirst($actionID) . '()';
				} else {
					$action = get_class($a) . '::run()';
				}
			}
			$actionParams = $controller->actionParams;
		}

		/* @var CWebUser $user */
		$user = Yii::app()->getComponent('user', false);

		return array(
			'flashes' => $user ? $user->getFlashes(false) : array(),
			'statusCode' => $this->getStatusCode(),
			'requestHeaders' => $requestHeaders,
			'responseHeaders' => $responseHeaders,
			'route' => $route,
			'action' => $action,
			'actionParams' => $actionParams,
			'SERVER' => empty($_SERVER) ? array() : $_SERVER,
			'GET' => empty($_GET) ? array() : $_GET,
			'POST' => empty($_POST) ? array() : $_POST,
			'COOKIE' => empty($_COOKIE) ? array() : $_COOKIE,
			'FILES' => empty($_FILES) ? array() : $_FILES,
			'SESSION' => empty($_SESSION) ? array() : $_SESSION,
		);
	}

	private $_statusCode;

	/**
	 * @return int|null
	 */
	protected function getStatusCode()
	{
		if (function_exists('http_response_code')) {
			return http_response_code();
		} else {
			return $this->_statusCode;
		}
	}

	public function __construct()
	{
		if (!function_exists('http_response_code')) {
			Yii::app()->attachEventHandler('onException', array($this, 'onException'));
		}
	}

	/**
	 * @param CExceptionEvent $event
	 */
	protected function onException($event)
	{
		if ($event->exception instanceof CHttpException) {
			$this->_statusCode = $event->exception->statusCode;
		} else {
			$this->_statusCode = 500;
		}
	}
}