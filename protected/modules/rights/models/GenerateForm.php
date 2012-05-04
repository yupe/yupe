<?php
/**
* Generation form class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class GenerateForm extends CFormModel
{
	public $items;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('items', 'safe'),
		);
	}
}
