<?php
/*## Bootstrap badge widget.
 * @see <http://twitter.github.com/bootstrap/components.html#badges>
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package bootstrap.widgets
 */
class TbBadge extends CWidget
{
	/*
	 * Valid badge types.
	 */
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_IMPORTANT = 'important';
	const TYPE_INFO = 'info';
	const TYPE_INVERSE = 'inverse';

	/**
	 * @var string the badge type.
	 *
	 * See `TYPE_*` constants for list of allowed types.
	 */
	public $type;

	/**
	 * @var string the badge text.
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
	 * At the start of widget we collect the attributes for badge tag.
	 */
	public function init()
	{
		$classes = array('badge');

		$validTypes = array(
			self::TYPE_SUCCESS,
			self::TYPE_WARNING,
			self::TYPE_IMPORTANT,
			self::TYPE_INFO,
			self::TYPE_INVERSE
		);

		if (isset($this->type) && in_array($this->type, $validTypes)) {
			$classes[] = 'badge-' . $this->type;
		}

		if (!empty($classes)) {
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class'])) {
				$this->htmlOptions['class'] .= ' ' . $classes;
			} else {
				$this->htmlOptions['class'] = $classes;
			}
		}

		if ($this->encodeLabel === true) {
			$this->label = CHtml::encode($this->label);
		}
	}

	/**
	 *### .run()
	 *
	 * Upon completing the badge we write the span tag with collected attributes to document.
	 */
	public function run()
	{
		echo CHtml::tag('span', $this->htmlOptions, $this->label);
	}
}
