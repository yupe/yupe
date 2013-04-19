<?php
/*## TbDatePicker widget class
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @package YiiBooster bootstrap.widgets
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

		if (!isset($this->options['language']))
			$this->options['language'] = substr(Yii::app()->getLanguage(), 0, 2);

		if (!isset($this->options['format']))
			$this->options['format'] = 'mm/dd/yyyy';

		if (!isset($this->options['weekStart']))
			$this->options['weekStart'] = 0; // Sunday
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		if ($this->hasModel())
		{
			if ($this->form)
				echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
			else
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);

		} else
			echo CHtml::textField($name, $this->value, $this->htmlOptions);

		$this->registerClientScript();
		$this->registerLanguageScript();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

		ob_start();
		echo "jQuery('#{$id}').datepicker({$options})";
		foreach ($this->events as $event => $handler)
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";

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
		Yii::app()->bootstrap->registerAssetCss('bootstrap-datepicker.css');
		Yii::app()->bootstrap->registerAssetJs('bootstrap.datepicker.js');
	}

	public function registerLanguageScript()
	{
		if (isset($this->options['language']) && $this->options['language'] != 'en')
		{
			$file = 'locales/bootstrap-datepicker.'.$this->options['language'].'.js';
			if (@file_exists(Yii::getPathOfAlias('bootstrap.assets').'/js/'.$file))
				Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-datepicker.'.$this->options['language'].'.js', CClientScript::POS_END);
		}
	}
}
