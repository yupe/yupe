<?php
/**
 *## TbHeroUnit class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @since 0.9.10
 */

/**
 *## Class TbHeroUnit
 *
 * Modest bootstrap hero unit widget.
 * Thanks to Christphe Boulain for suggesting content capturing.
 * @see <http://twitter.github.com/bootstrap/components.html#typography>
 *
 * @package booster.widgets.decoration
 */
class TbHeroUnit extends CWidget
{
	/**
	 * @var string the heading text.
	 */
	public $heading;

	/**
	 * @var boolean indicates whether to encode the heading.
	 */
	public $encodeHeading = true;

	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * @var array the HTML attributes for the heading element.
	 * @since 1.0.0
	 */
	public $headingOptions = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		if (isset($this->htmlOptions['class'])) {
			$this->htmlOptions['class'] .= ' hero-unit';
		} else {
			$this->htmlOptions['class'] = 'hero-unit';
		}

		echo CHtml::openTag('div', $this->htmlOptions);

		if ($this->encodeHeading) {
			$this->heading = CHtml::encode($this->heading);
		}

		if (isset($this->heading)) {
			echo CHtml::tag('h1', $this->headingOptions, $this->heading);
		}
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::closeTag('div');
	}
}
