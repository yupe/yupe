<?php
/**
* Auth item assignment form class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9
*/
class AssignmentForm extends CFormModel
{
	public $itemname;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('itemname', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => Rights::t('core', 'Authorization item'),
		);
	}
}
