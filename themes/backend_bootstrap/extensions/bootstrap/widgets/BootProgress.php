<?php
/**
 * BootProgress class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

/**
 * Bootstrap progress bar widget.
 */
class BootProgress extends CWidget
{
	// Progress bar types.
	const TYPE_DEFAULT = '';
	const TYPE_INFO = 'info';
	const TYPE_SUCCESS = 'success';
	const TYPE_DANGER = 'danger';

	/**
	 * @var string the bar type.
	 * Valid values are '', 'info', 'success', and 'danger'.
	 */
	public $type = self::TYPE_DEFAULT;
	/**
	 * @var boolean whether the bar is striped.
	 */
	public $striped = false;
	/**
	 * @var boolean whether the bar is animated.
	 */
	public $animated = false;
	/**
	 * @var integer the progress.
	 */
	public $percent = 0;
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = array('progress');

		$validTypes = array(self::TYPE_DEFAULT, self::TYPE_INFO, self::TYPE_SUCCESS, self::TYPE_DANGER);
		if ($this->type !== self::TYPE_DEFAULT && in_array($this->type, $validTypes))
			$classes[] = 'progress-'.$this->type;

		if ($this->striped)
			$classes[] = 'progress-striped';

		if ($this->animated)
			$classes[] = 'active';

		$classes = implode(' ', $classes);
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

		if ($this->percent < 0)
			$this->percent = 0;
		else if ($this->percent > 100)
			$this->percent = 100;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="bar" style="width: '.$this->percent.'%;"></div>';
		echo '</div>';
	}
}
