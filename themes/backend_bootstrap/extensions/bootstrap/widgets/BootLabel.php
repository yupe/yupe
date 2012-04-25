<?php
/**
 * BootLabel class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap label widget.
 */
class BootLabel extends BootWidget
{
	// Label types.
	const TYPE_DEFAULT = '';
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_IMPORTANT = 'important';
	const TYPE_INFO = 'info';
	const TYPE_INVERSE = 'inverse';

	/**
	 * @var string the label type (defaults to '').
	 * Valid types are '', 'success', 'warning', 'important', 'info' and 'inverse'.
	 */
	public $type = self::TYPE_DEFAULT;
	/**
	 * @var string the label text.
	 */
	public $label;
	/**
	 * @var boolean whether to encode the label.
	 */
	public $encodeLabel = true;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = array('label');

		$validTypes = array(self::TYPE_SUCCESS, self::TYPE_WARNING,
				self::TYPE_IMPORTANT, self::TYPE_INFO, self::TYPE_INVERSE);

		if (in_array($this->type, $validTypes))
			$classes[] = 'label-'.$this->type;

		$cssClass = implode(' ', $classes);
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$cssClass;
		else
			$this->htmlOptions['class'] = $cssClass;

		if ($this->encodeLabel === true)
			$this->label = CHtml::encode($this->label);
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::tag('span', $this->htmlOptions, $this->label);
	}
}
