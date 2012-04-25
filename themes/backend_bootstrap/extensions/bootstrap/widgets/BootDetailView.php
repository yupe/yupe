<?php
/**
 * BootDetailView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.CDetailView');

/**
 * Bootstrap detail view widget.
 * Used for setting default HTML classes and disabling the default CSS.
 */
class BootDetailView extends CDetailView
{
	// Table types.
	const TYPE_PLAIN = '';
	const TYPE_STRIPED = 'striped';
	const TYPE_BORDERED = 'bordered';
	const TYPE_CONDENSED = 'condensed';

	/**
	 * @var string|array the table type.
	 * Valid values are '', 'striped', 'bordered' and/or 'condensed'.
	 */
	public $type = array(self::TYPE_STRIPED, self::TYPE_CONDENSED);
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		$class = array('table');

		if (is_string($this->type))
			$this->type = explode(' ', $this->type);

		$validTypes = array(self::TYPE_STRIPED, self::TYPE_BORDERED, self::TYPE_CONDENSED);

		foreach ($this->type as $type)
			if (in_array($type, $validTypes))
				$class[] = 'table-'.$type;

		$cssClass = implode(' ', $class);
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$cssClass;
		else
			$this->htmlOptions['class'] = $cssClass;
	}
}
