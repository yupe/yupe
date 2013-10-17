<?php
/**
 * IWikiUser
 */
interface IWikiUser
{
	/**
	 * @abstract
	 * @param mixed $id ID of the user.
	 * @return string name of the user.
	 */
	public function getNameById($id);

	/**
	 * @abstract
	 * @param int $id ID of the user.
	 * @return string email of the user.
	 */
	public function getEmailById($id);
}
