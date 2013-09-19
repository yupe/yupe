<?php
/**
 *## TbTimePicker class file.
 */

/**
 *## TbTimePicker widget.
 *
 * @see http://jdewit.github.com/bootstrap-timepicker/
 * @see https://github.com/jdewit/bootstrap-timepicker
 *
 * @since 1.0.3
 * @package booster.widgets.forms.inputs
 */
class TbTimePicker extends CInputWidget
{
	/**
	 * @var TbActiveForm If we're called from the form, here lies the reference to it.
	 */
	public $form;

	/**
	 * @var array The options for the "bootstrap-timepicker" plugin.
	 * @see http://jdewit.github.com/bootstrap-timepicker/
	 *
	 * Available options:
	 * template    string
	 *      'dropdown' (default), Show picker in a dropdown
	 *      'modal', Show picker in a modal
	 *      false, Don't show a widget
	 * minuteStep    integer    15    Specify a step for the minute field.
	 * showSeconds    boolean    false    Show the seconds field.
	 * secondStep    integer    15    Specify a step for the second field.
	 * defaultTime    string
	 *      'current' (default) Set to the current time.
	 *      'value' Set to inputs current value
	 *      false    Do not set a default time
	 * showMeridian    boolean
	 *      true (default)  12hr mode
	 *      false24hr mode
	 * showInputs    boolean
	 *      true (default )Shows the text inputs in the widget.
	 *      false Hide the text inputs in the widget
	 * disableFocus    boolean    false    Disables the input from focusing. This is useful for touch screen devices that
	 *          display a keyboard on input focus.
	 * modalBackdrop    boolean    false    Show modal backdrop.
	 */
	public $options = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 * @deprecated 2.0.0 You have the ability to set unique ID and/or class to this element.
	 * Define Javascript handlers inside Javascript files, not here.
	 * You can generate the Javascript files from PHP, too, there's no need in hand-crafted snippets of Javascript polluting view files.
	 */
	public $events = array();

	/**
	 * @var array HTML attributes for the wrapper "div" tag.
	 */
	public $wrapperHtmlOptions = array();

	/**
	 * @var boolean Whether to not append the time icon at end of input.
	 * NOTE that the timepicker is opening after click on this icon if it's present!
	 */
	public $noAppend = false;

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		// Add a class of no-user-select to widget
		$this->htmlOptions['class'] = empty($this->htmlOptions['class'])
			? 'no-user-select'
			: 'no-user-select ' . $this->htmlOptions['class'];

		// We are overriding the result of $this->resolveNameID() here, because $id which it emits is not unique through the page.
		if (empty($this->htmlOptions['id'])) {
			$this->htmlOptions['id'] = $this->getId(true) . '-' . $id;
		}

		// Adding essential class for timepicker to work.
		$this->wrapperHtmlOptions = $this->injectClass($this->wrapperHtmlOptions, 'bootstrap-timepicker');

		if (!$this->noAppend)
			$this->wrapperHtmlOptions = $this->injectClass($this->wrapperHtmlOptions, 'input-append');


		echo CHtml::openTag('div', $this->wrapperHtmlOptions);
		if ($this->hasModel()) {
			if ($this->form) {
				echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			} else {
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
			}
		} else {
			echo CHtml::textField($name, $this->value, $this->htmlOptions);
		}
		if (!$this->noAppend)
			$this->echoAppend();
		echo CHtml::closeTag('div');

		$this->registerClientScript($this->htmlOptions['id']);
	}

	/**
	 * Registers required javascript files
	 *
	 * @param string $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->assetsRegistry->registerPackage('timepicker');

		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();

		echo "jQuery('#{$id}').timepicker({$options})";
		foreach ($this->events as $event => $handler) {
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
		}

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, ob_get_clean() . ';');
	}

	/**
	 * @param array $valueset
	 * @param string $className
	 *
	 * @return array
	 */
	private function injectClass($valueset, $className)
	{
		if (array_key_exists('class', $valueset) and is_string($valueset['class'])) {
			$valueset['class'] = implode(
				' ',
				array_merge(
					explode(
						' ',
						$valueset['class']
					),
					array($className)
				)
			);
		} else {
			$valueset['class'] = $className;
		}

		return $valueset;
	}

	private function echoAppend()
	{
		echo CHtml::tag('span', array('class' => 'add-on'), CHtml::tag('i', array('class' => 'icon-time'), ''));
	}
}
