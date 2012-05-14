<?php
/**
 * Default authentication backend that relies on CWebUser to get id, name, isGuest
 * and check access. Doesn't implement getting email so
 */
class YiiAuth implements IWikiAuth
{
	/**
	 * @return string Name of the currently logged in user
	 */
	public function getUserName()
	{
		return Yii::app()->user->name;
	}

	/**
	 * @return string Unique ID of the user
	 */
	public function getUserId()
	{
		return Yii::app()->user->id;
	}

	/**
	 * @return bool if user isn't logged in
	 */
	public function isGuest()
	{
		return Yii::app()->user->isGuest;
	}

	/**
	 * @param string $operation the name of the operation that need access check.
	 * @param array $params name-value pairs that would be passed to the operation
	 * check routine.
	 *
	 * @return bool whether the operation can be performed by this user.
	 */
	public function checkAccess($operation,$params)
	{
		return Yii::app()->user->checkAccess($operation,$params);
	}
}
