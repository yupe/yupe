<?php
/**
 *## TbDatePicker widget class
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 * Bootstrap DatePicker widget
 * @see http://www.eyecon.ro/bootstrap-datepicker/
 *
 * @package booster.widgets.forms.inputs
 */
class TbDatePicker extends CInputWidget
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
			$this->options['language'] = substr(Yii::app()->getLanguage(), 0, 2);
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
				echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			} else {
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
			}

		} else {
			echo CHtml::textField($name, $this->value, $this->htmlOptions);
		}

		$this->registerClientScript();
		$this->registerLanguageScript();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();
		echo "jQuery('#{$id}').datepicker({$options})";
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
		Yii::app()->bootstrap->registerPackage('datepicker');
	}

	public function registerLanguageScript()
	{
		if (isset($this->options['language']) && $this->options['language'] != 'en') {
			$file = 'locales/bootstrap-datepicker.' . $this->options['language'] . '.js';
			if (@file_exists(Yii::getPathOfAlias('bootstrap.assets') . '/js/' . $file)) {
				if (Yii::app()->bootstrap->enableCdn) {
					Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.1.3/js/locales/bootstrap-datepicker.' . $this->options['language'] . '.js', CClientScript::POS_END);
				} else {
					Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-datepicker.' . $this->options['language'] . '.js');
				}
			}
		}
	}
}
