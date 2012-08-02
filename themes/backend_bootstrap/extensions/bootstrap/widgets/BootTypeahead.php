<?php
/**
 * BootTypeahead class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

/**
 * Bootstrap type-a-head widget.
 */
class BootTypeahead extends CWidget
{
	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $options = array();
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['data-provide'] = 'typeahead';
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->id;

		echo CHtml::tag('input', $this->htmlOptions);

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').typeahead({$options});");
	}
}
