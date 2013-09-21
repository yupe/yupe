<?php
/**
 *## TbAlert class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 *## Bootstrap alert widget.
 *
 * Alert widget displays the messages set via CWebUser.setFlash() using the Twitter Bootstrap Alert widget.
 *
 * @see http://twitter.github.com/bootstrap/javascript.html#alerts
 *
 * @package booster.widgets.decoration
 */
class TbAlert extends CWidget
{
	const TYPE_SUCCESS = 'success';
	const TYPE_INFO = 'info';
	const TYPE_WARNING = 'warning';
	const TYPE_ERROR = 'error';
	const TYPE_DANGER = 'danger'; // same as error

	/**
	 * @var array The configuration for individual types of alerts.
	 *
	 * Here's the allowed array elements:
	 *
	 * 'visible' (= null) If set to false, this type of alerts will not be rendered.
	 * 'block' (= widget value) The same as a global block property.
	 *   If set, size of alert block will be larger.
	 *   It defaults to the widget-level block property value.
	 * 'fade' (= widget value) The same as a global fade property.
	 *   If set, alert will close itself fading away.
	 *   It defaults to the widget-level fade property value.
	 * 'htmlOptions' (= array()) Attributes for the individual alert panels.
	 *   Widget-level htmlOptions was for wrapper element around them.
	 *   Note that the class attribute will be appended with classes required for alert to be Twitter Bootstrap alert.
	 * 'closeText' (= widget value) The same as a global closeText property.
	 *   If set to false, close button will be removed from this type of alert.
	 *   It defaults to the widget-level closeText property value.
	 *
	 * @note Instead of full arrays you can use just the names of alert types as a values of the alerts property.
	 * You can even mix the array configuration and plain names.
	 *
	 * Default is the array of all alert types defined as TYPE_* constants.
	 * If you want no alerts to be displayed, set this property to empty array, not `null` value.
	 */
	public $alerts;

	/**
	 * @var string|boolean What to render as a button to close the alert panel.
	 *
	 * Default is to render a diagonal cross symbol.
	 * If set to false, no close button will be rendered, making user unable to close the alert.
	 */
	public $closeText = '&times;';

	/**
	 * @var boolean When set, alert has a larger block size. Defaults to 'true'
	 */
	public $block = true;

	/**
	 * @var boolean When set, alert will fade out using transitions when closed. Defaults to 'true'
	 */
	public $fade = true;

	/**
	 * @var string[] The Javascript event handlers attached to all alert elements being rendered.
	 *
	 * It should be an array with elements being a javascript string containing event handler function definition (along with declaration) and indexed with the names of events.
	 * This will be fed to jQuery.on verbatim.
	 *
	 * @volatile
	 */
	public $events = array();

	/**
	 * @var array Traditional property to set attributes to the element wrapping all of alerts.
	 */
	public $htmlOptions = array();

	/**
	 * @var string Name of the component which will be used to get alert messages.
	 *
	 * It should implement getFlash() method which returns alert message by its type.
	 * Default is 'user'.
	 */
	public $userComponentId = 'user';

	protected static $_containerId = 0;

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id'])) {
			$this->htmlOptions['id'] = $this->getId();
		}

		if (is_string($this->alerts)) {
			$this->alerts = array($this->alerts);
		}

		// Display all alert types by default.
		if (!isset($this->alerts)) {
			$this->alerts = array(
				self::TYPE_SUCCESS,
				self::TYPE_INFO,
				self::TYPE_WARNING,
				self::TYPE_ERROR,
				self::TYPE_DANGER
			);
		}
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->htmlOptions['id'];

		echo CHtml::openTag('div', $this->htmlOptions);

		foreach ($this->alerts as $type => $alert) {

			if (is_string($alert)) {
				$type = $alert;
				$alert = array();
			}

			if (isset($alert['visible']) && $alert['visible'] === false) {
				continue;
			}

			/** @var CWebUser $userComponent */
			$userComponent = Yii::app()->getComponent($this->userComponentId);
			if (!$userComponent->hasFlash($type))
				continue;

			$alertText = $userComponent->getFlash($type);

			$this->renderSingleAlert($alert, $type, $alertText);
		}

		echo CHtml::closeTag('div');

		$id .= '_' . self::$_containerId++;
		$selector = "#{$id} .alert";

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__ . '#' . $id, "jQuery('{$selector}').alert();");

		foreach ($this->events as $name => $handler) {
			$handler = CJavaScript::encode($handler);
			$cs->registerScript(
				__CLASS__ . '#' . $id . '_' . $name,
				"jQuery('{$selector}').on('{$name}', {$handler});"
			);
		}
	}

	/**
	 * @param $alert
	 * @param $type
	 * @param $alertText
	 */
	protected function renderSingleAlert($alert, $type, $alertText)
	{
		$classes = array('alert in');

		if (!isset($alert['block'])) {
			$alert['block'] = $this->block;
		}

		if ($alert['block'] === true) {
			$classes[] = 'alert-block';
		}

		if (!isset($alert['fade'])) {
			$alert['fade'] = $this->fade;
		}

		if ($alert['fade'] === true) {
			$classes[] = 'fade';
		}

		$validTypes = array(
			self::TYPE_SUCCESS,
			self::TYPE_INFO,
			self::TYPE_WARNING,
			self::TYPE_ERROR,
			self::TYPE_DANGER
		);

		if (in_array($type, $validTypes)) {
			$classes[] = 'alert-' . $type;
		}

		if (!isset($alert['htmlOptions'])) {
			$alert['htmlOptions'] = array();
		}

		$classes = implode(' ', $classes);
		if (isset($alert['htmlOptions']['class'])) {
			$alert['htmlOptions']['class'] .= ' ' . $classes;
		} else {
			$alert['htmlOptions']['class'] = $classes;
		}

		echo CHtml::openTag('div', $alert['htmlOptions']);

		// Logic is this: if no type-specific `closeText` was defined, let's show `$this->closeText`.
		// Else, show type-specific `closeText`. Treat 'false' differently.
		if (!isset($alert['closeText'])) {
			$alert['closeText'] = (isset($this->closeText) && $this->closeText !== false)
				? $this->closeText
				: false;
		}

		// If `closeText` which is in effect now is `false` then do not show button.
		if ($alert['closeText'] !== false) {
			echo '<a href="#" class="close" data-dismiss="alert">' . $alert['closeText'] . '</a>';
		}

		echo $alertText;
		echo CHtml::closeTag('div');
	}
}
