<?php
/**
 *## TbPickerColumn class file
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.TbDataColumn');

/**
 *## Class TbPickerColumn
 *
 * The TbPickerColumn works with TbJsonGridView and allows you to create a column that will display a picker element
 * The picker is a special plugin that renders a dropdown on click, which contents can be dynamically updated.
 *
 * @package booster.widgets.grids.columns
 */
class TbPickerColumn extends TbDataColumn
{
	/**
	 * @var string $class the class name to use to display picker
	 */
	public $class = 'bootstrap-picker';

	/**
	 * @var array $pickerOptions the javascript options for the picker bootstrap plugin. The picker bootstrap plugin
	 * extends from the tooltip plugin.
	 *
	 * Note that picker has also a 'width' just in case we display AJAX'ed content.
	 *
	 * @see http://twitter.github.com/bootstrap/javascript.html#tooltips
	 */
	public $pickerOptions = array();

	/**
	 * Initialization function
	 */
	public function init()
	{
		if (!$this->class) {
			$this->class = 'bootstrap-picker';
		}
		$this->registerClientScript();
	}

	/**
	 * Renders a data cell content, wrapping the value with the link that will activate the picker
	 *
	 * @param int $row
	 * @param mixed $data
	 */
	public function renderDataCellContent($row, $data)
	{

		if ($this->value !== null) {
			$value = $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));
		} else if ($this->name !== null) {
			$value = CHtml::value($data, $this->name);
		}

		$class = preg_replace('/\s+/', '.', $this->class);
		$value = !isset($value) ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value, $this->type);
		$value = CHtml::link($value, '#', array('class' => $class));

		echo $value;
	}

	/**
	 * Registers client script data
	 */
	public function registerClientScript()
	{
		/** @var $cs CClientScript */
		$cs = Yii::app()->getClientScript();

		$cs->registerPackage('picker');

		$pickerOptions = CJavaScript::encode($this->pickerOptions);
		$gridId = $this->grid->id;
		$class = preg_replace('/\s+/', '.', $this->class);

		// Registering script to properly open *only* the picker for which corresponding toggler was clicked,
		// and close all other pickers.
		$cs->registerScript(
			__CLASS__ . '#' . $this->id,
			<<<ENDL
$(document).on('click','#{$gridId} a.{$class}', function() {
	if ($(this).hasClass('pickeron')) {
		$(this).removeClass('pickeron').picker('toggle');
		return;
	}
	$('#{$gridId} a.pickeron')
		.removeClass('pickeron')
		.each(function (i, elem) {
			$(elem).picker('toggle');
		});
	$(this)
		.picker({$pickerOptions})
		.picker('toggle').addClass('pickeron'); return false;
});
ENDL
		);
	}
}
