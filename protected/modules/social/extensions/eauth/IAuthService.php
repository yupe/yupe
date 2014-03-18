<?php
/**
 * IAuthService interface file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * IAuthService is the interface for all service types and providers.
 *
 * @package application.extensions.eauth
 */
interface IAuthService {

	/**
	 * Initizlize the component.
	 *
	 * @param EAuth $component the component instance.
	 * @param array $options properties initialization.
	 */
	public function init($component, $options = array());


	/**
	 * Returns service name(id).
	 */
	public function getServiceName();

	/**
	 * Returns service title.
	 */
	public function getServiceTitle();

	/**
	 * Returns service type (e.g. OpenID, OAuth).
	 */
	public function getServiceType();

	/**
	 * Returns arguments for the jQuery.eauth() javascript function.
	 */
	public function getJsArguments();


	/**
	 * Sets {@link EAuth} application component
	 *
	 * @param EAuth $component the application auth component.
	 */
	public function setComponent($component);

	/**
	 * Returns the {@link EAuth} application component.
	 */
	public function getComponent();


	/**
	 * Sets redirect url after successful authorization.
	 *
	 * @param string url to redirect.
	 */
	public function setRedirectUrl($url);

	/**
	 * Returns the redirect url after successful authorization.
	 */
	public function getRedirectUrl();


	/**
	 * Sets redirect url after unsuccessful authorization (e.g. user canceled).
	 *
	 * @param string url to redirect.
	 */
	public function setCancelUrl($url);

	/**
	 * Returns the redirect url after unsuccessful authorization (e.g. user canceled).
	 */
	public function getCancelUrl();


	/**
	 * Authenticate the user.
	 */
	public function authenticate();

	/**
	 * Whether user was successfuly authenticated.
	 */
	public function getIsAuthenticated();


	/**
	 * Redirect to the url. If url is null, {@link redirectUrl} will be used.
	 *
	 * @param string $url url to redirect.
	 */
	public function redirect($url = null);

	/**
	 * Redirect to the {@link cancelUrl} or simply close the popup window.
	 */
	public function cancel();


	/**
	 * Returns the user unique id.
	 */
	public function getId();

	/**
	 * Returns the array that contains all available authorization attributes.
	 */
	public function getAttributes();

	/**
	 * Returns the authorization attribute value.
	 *
	 * @param string $key the attribute name.
	 * @param mixed $default the default value.
	 */
	public function getAttribute($key, $default = null);

	/**
	 * Whether the authorization attribute exists.
	 *
	 * @param string $key the attribute name.
	 */
	public function hasAttribute($key);

	/**
	 * Returns an object with a human-readable representation of the current authorization.
	 */
	public function getItem();

}