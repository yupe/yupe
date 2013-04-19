<?php
/*## TbDateRangePicker class file.
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package YiiBooster bootstrap.widgets
 */

/**
 * A simple implementation for date range picker for Twitter Bootstrap
 * @see <http://www.dangrossman.info/2012/08/20/a-date-range-picker-for-twitter-bootstrap/>
 */
class TbDateRangePicker extends CInputWidget
{
	/**
	 * @var TbActiveForm when created via TbActiveForm.
	 * this attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;

	/**
	 * @var string $selector
	 */
	public $selector;

	/**
	 * @var string JS Callback for Daterange picker
	 */
	public $callback;

	/**
	 * @var array Options to be passed to daterange picker
	 */
	public $options = array();

	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{
		$this->registerClientScript();
	}

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		if ($this->selector)
			Yii::app()->bootstrap->registerDateRangePlugin($this->selector, $this->options, $this->callback);
		else
		{
			list($name, $id) = $this->resolveNameID();

			if ($this->hasModel())
			{
				if ($this->form)
					echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
				else
					echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);

			} 
			else
				echo CHtml::textField($name, $this->value, $this->htmlOptions);

			$this->setLocaleSettings();
			Yii::app()->bootstrap->registerDateRangePlugin('#' . $id, $this->options, $this->callback);	
		}

	}

	/**
	 *### .setLocaleSettings()
	 *
	 * If user did not provided the names of weekdays and months in $this->options['locale']
	 *  (which he should not care about anyway)
	 *  then we populate this names from Yii's locales database.
	 * 
	 *  This method works with the local properties directly, beware.
	 */
	private function setLocaleSettings()
	{
		$this->setDaysOfWeekNames();
		$this->setMonthNames();
	}

	/**
	 *### .setDaysOfWeekNames()
	 */
	private function setDaysOfWeekNames()
	{
		if (empty($this->options['locale']['daysOfWeek']))
			$this->options['locale']['daysOfWeek'] = Yii::app()->locale->getWeekDayNames('narrow', true);
	}

	/**
	 *### .setMonthNames()
	 */
	private function setMonthNames()
	{
		if (empty($this->options['locale']['monthNames']))
			$this->options['locale']['monthNames'] = array_values(Yii::app()->locale->getMonthNames('wide', true));
	}

	/**
	 *### .registerClientScript()
	 *
	 * Registers required css js files
	 */
	public function registerClientScript()
	{
		Yii::app()->bootstrap->registerAssetCss('bootstrap-daterangepicker.css');
		Yii::app()->bootstrap->registerAssetJs('bootstrap.daterangepicker.js');
		Yii::app()->bootstrap->registerAssetJs('date.js');
	}
}
