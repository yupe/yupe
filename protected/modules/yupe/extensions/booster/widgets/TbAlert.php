<?php
/*## TbAlert class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @package bootstrap.widgets
 */

/**
 * Bootstrap alert widget.
 *
 * @see http://twitter.github.com/bootstrap/javascript.html#alerts
 */
class TbAlert extends CWidget
{
	// Alert types.
	const TYPE_SUCCESS = 'success';
	const TYPE_INFO = 'info';
	const TYPE_WARNING = 'warning';
	const TYPE_ERROR = 'error';
	const TYPE_DANGER = 'danger'; // same as error

	/**
	 * @var array the alerts configurations.
	 */
	public $alerts;

	/**
	 * @var string|boolean the close link text.
	 * If this is set false, no close link will be displayed.
	 */
	public $closeText = '&times;';

	/**
	 * @var boolean indicates whether the alert should be an alert block. Defaults to 'true'.
	 */
	public $block = true;

	/**
	 * @var boolean indicates whether alerts should use transitions. Defaults to 'true'.
	 */
	public $fade = true;

	/**
	 * @var string[] the Javascript event handlers.
	 */
	public $events = array();

	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * @var string User-component for getting flash messages.
	 */
	public $userComponentId = 'user';

	private static $_containerId = 0;

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

			if (Yii::app()->getComponent($this->userComponentId)->hasFlash($type)) {
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

				echo Yii::app()->getComponent($this->userComponentId)->getFlash($type);
				echo '</div>';
			}
		}

		echo '</div>';

		$selector = "#{$id} .alert";
		$id .= '_' . self::$_containerId++;

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
}
