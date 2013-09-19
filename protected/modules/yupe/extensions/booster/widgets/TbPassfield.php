<?php
/**
 *## TbPassfield widget class
 *
 * @author: Hrumpa
 * @copyright
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 * Bootstrap Pass*Field widget
 * @see http://antelle.github.io/passfield/
 *
 * @package booster.widgets.forms.inputs
 */
class TbPassfield extends CInputWidget
{
	/**
	 * @var TbActiveForm when created via TbActiveForm.
	 * This attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;

	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $options = array();

	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->htmlOptions['type'] = 'text';
		$this->htmlOptions['autocomplete'] = 'off';

		if (!isset($this->options['language'])) {
			$this->options['locale'] = substr(Yii::app()->getLanguage(), 0, 2);
		} else {
			$this->options['locale'] = $this->options['language'];
		}

	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		if ($this->hasModel()) {
			if ($this->form) {
				echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
			} else {
				echo CHtml::activePasswordField($this->model, $this->attribute, $this->htmlOptions);
			}

		} else {
			echo CHtml::passwordField($name, $this->value, $this->htmlOptions);
		}

		$this->registerClientScript();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();
		echo "jQuery('#{$id}').passField({$options})";
		foreach ($this->events as $event => $handler) {
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
		}

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');

	}

	/**
	 *### .registerClientScript()
	 *
	 * Registers required client script for bootstrap datepicker. It is not used through bootstrap->registerPlugin
	 * in order to attach events if any
	 */
	public function registerClientScript()
	{
		Yii::app()->bootstrap->registerPackage('passfield');
	}

}
