<?php
/**
 * WikiUser
 */
class WikiUser implements IWikiUser
{
	/**
	 * @param mixed $id ID of the user.
	 *
	 * @return string name of the user.
	 */
	public function getNameById($id)
	{
		$user = User::model()->findByPk($id);
		return $user->name;
	}

	/**
	 * @param int $id ID of the user.
	 *
	 * @return string email of the user.
	 */
	public function getEmailById($id)
	{
		$user = User::model()->findByPk($id);
		return $user->email;
	}
}
