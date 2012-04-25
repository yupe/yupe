<?php
/**
 * BootTypeahead class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap type-a-head widget.
 */
class BootTypeahead extends BootWidget
{
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['data-provide'] = 'typeahead';

		Yii::app()->bootstrap->registerTypeahead();
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::tag('input', $this->htmlOptions);

		$id = $this->id;
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').typeahead({$options});");
	}
}
