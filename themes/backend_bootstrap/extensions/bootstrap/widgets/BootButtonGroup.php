<?php
/**
 * BootButtonGroup class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

Yii::import('bootstrap.widgets.BootButton');

/**
 * Bootstrap button group widget.
 */
class BootButtonGroup extends CWidget
{
	// Toggle options.
	const TOGGLE_CHECKBOX = 'checkbox';
	const TOGGLE_RADIO = 'radio';

	/**
	 * @var string the button callback type.
	 * @see BootButton::buttonType
	 */
	public $buttonType = BootButton::BUTTON_LINK;
	/**
	 * @var string the button type.
	 * @see BootButton::type
	 */
	public $type = BootButton::TYPE_NORMAL;
	/**
	 * @var string the button size.
	 * @see BootButton::size
	 */
	public $size = BootButton::SIZE_NORMAL;
	/**
	 * @var boolean indicates whether to encode the button labels.
	 */
	public $encodeLabel = true;
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();
	/**
	 * @var array the button configuration.
	 */
	public $buttons = array();
	/**
	 * @var boolean indicates whether to enable button toggling.
	 */
	public $toggle;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$classes = 'btn-group';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

		$validToggles = array(self::TOGGLE_CHECKBOX, self::TOGGLE_RADIO);

		if (isset($this->toggle) && in_array($this->toggle, $validToggles))
			$this->htmlOptions['data-toggle'] = 'buttons-'.$this->toggle;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::openTag('div', $this->htmlOptions);

		foreach ($this->buttons as $button)
		{
			$this->controller->widget('bootstrap.widgets.BootButton', array(
				'buttonType'=>isset($button['buttonType']) ? $button['buttonType'] : $this->buttonType,
				'type'=>isset($button['type']) ? $button['type'] : $this->type,
				'size'=>$this->size,
				'icon'=>isset($button['icon']) ? $button['icon'] : null,
				'label'=>isset($button['label']) ? $button['label'] : null,
				'url'=>isset($button['url']) ? $button['url'] : null,
				'active'=>isset($button['active']) ? $button['active'] : false,
				'items'=>isset($button['items']) ? $button['items'] : array(),
				'ajaxOptions'=>isset($button['ajaxOptions']) ? $button['ajaxOptions'] : array(),
				'htmlOptions'=>isset($button['htmlOptions']) ? $button['htmlOptions'] : array(),
				'encodeLabel'=>isset($button['encodeLabel']) ? $button['encodeLabel'] : $this->encodeLabel,
			));
		}

		echo '</div>';
	}
}
