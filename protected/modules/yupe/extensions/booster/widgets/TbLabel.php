<?php
/*## TbLabel class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @package bootstrap.widgets
 */

/**
 * Bootstrap label widget.
 * @see <http://twitter.github.com/bootstrap/components.html#labels>
 */
class TbLabel extends CWidget
{
	// Label types.
	const TYPE_SUCCESS   = 'success';
	const TYPE_WARNING   = 'warning';
	const TYPE_IMPORTANT = 'important';
	const TYPE_INFO      = 'info';
	const TYPE_INVERSE   = 'inverse';

	/**
	 * @var string the label type.
	 *
	 * Valid types are 'success', 'warning', 'important', 'info' and 'inverse'.
	 */
	public $type;

	/**
	 * @var string the label text.
	 */
	public $label;

	/**
	 * @var boolean whether to encode the label.
	 */
	public $encodeLabel = true;

	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = array('label');

		$validTypes = array(self::TYPE_SUCCESS, self::TYPE_WARNING, self::TYPE_IMPORTANT, self::TYPE_INFO, self::TYPE_INVERSE);

		if (isset($this->type) && in_array($this->type, $validTypes))
			$classes[] = 'label-'.$this->type;

		if (!empty($classes))
		{
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] .= ' '.$classes;
			else
				$this->htmlOptions['class'] = $classes;
		}

		if ($this->encodeLabel === true)
			$this->label = CHtml::encode($this->label);
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::tag('span', $this->htmlOptions, $this->label);
	}
}
