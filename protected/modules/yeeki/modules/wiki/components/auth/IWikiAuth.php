<?php
/**
 * IWikiAuth
 */
interface IWikiAuth
{
	/**
	 * @abstract
	 * @return string Name of the currently logged in user
	 */
	public function getUserName();

	/**
	 * @abstract
	 * @return string Unique ID of the user
	 */
	public function getUserId();

	/**
	 * @abstract
	 * @return bool if user isn't logged in
	 */
	public function isGuest();

	/**
	 * @abstract
	 * @param string $operation the name of the operation that need access check.
	 * @param array $params name-value pairs that would be passed to the operation
	 * check routine.
	 * @return bool whether the operation can be performed by this user.
	 */
	public function checkAccess($operation,$params);
}