<?php
/**
 * BootHero class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

/**
 * Modest bootstrap hero widget.
 * Thanks to Christphe Boulain for suggesting content capturing.
 */
class BootHero extends CWidget
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
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = 'hero-unit';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

		if ($this->encodeHeading)
			$this->heading = CHtml::encode($this->heading);

		ob_start();
		ob_implicit_flush(false);
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$content = ob_get_clean();
		echo CHtml::openTag('div', $this->htmlOptions);

		if (isset($this->heading))
			echo CHtml::tag('h1', array(), $this->heading);

		echo $content;
		echo '</div>';
	}
}
