<?php
/**
 *## TbInputInline class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.input.TbInputVertical');

/**
 *## TbInputInline class
 *
 * Bootstrap vertical form input widget.
 *
 * @since 0.9.8
 * @package booster.widgets.forms.inputs
 */
class TbInputInline extends TbInputVertical
{
	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 */
	protected function dropDownList()
	{
		echo $this->getLabel();
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
	}

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 */
	protected function passwordField()
	{
		$this->setPlaceholder();
		echo $this->getPrepend();
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
	}

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 */
	protected function textArea()
	{
		$this->setPlaceholder();
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
	}

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField()
	{
		$this->setPlaceholder();
		echo $this->getPrepend();
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
	}

	/**
	 * Renders a masked text field.
	 * @return string the rendered content
	 */
	protected function maskedTextField()
	{
		$this->setPlaceholder();
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->getPrepend();
		echo $this->form->maskedTextField($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getAppend();
	}

	/**
	 * Renders a masked text field.
	 * @return string the rendered content
	 */
	protected function typeAheadField()
	{
		$this->setPlaceholder();
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->getPrepend();
		echo $this->form->typeAheadField($this->model, $this->attribute, $this->data, $this->htmlOptions);
		echo $this->getAppend();
	}

     /**
     * Renders a datepicker field.
     * @return string the rendered content
     * @author antonio ramirez <antonio@clevertech.biz>
     */
    protected function datepickerField()
    {
        if (isset($this->htmlOptions['options'])) {
            $options = $this->htmlOptions['options'];
            unset($this->htmlOptions['options']);
        }

        if (isset($this->htmlOptions['events'])) {
            $events = $this->htmlOptions['events'];
            unset($this->htmlOptions['events']);
        }

        echo $this->setPlaceholder();
        echo $this->getPrepend();
        $this->widget(
            'bootstrap.widgets.TbDatePicker',
            array(
                'model' => $this->model,
                'attribute' => $this->attribute,
                'options' => isset($options) ? $options : array(),
                'events' => isset($events) ? $events : array(),
                'htmlOptions' => $this->htmlOptions,
            )
        );
        echo $this->getAppend();
        echo $this->getError() . $this->getHint();
    }

     /**
     * Renders a datetimepicker field.
     * @return string the rendered content
     * @author Hrumpa
     */
    protected function datetimepickerField()
    {
        if (isset($this->htmlOptions['options'])) {
            $options = $this->htmlOptions['options'];
            unset($this->htmlOptions['options']);
        }

        if (isset($this->htmlOptions['events'])) {
            $events = $this->htmlOptions['events'];
            unset($this->htmlOptions['events']);
        }

        echo $this->setPlaceholder();
        echo $this->getPrepend();
        $this->widget(
            'bootstrap.widgets.TbDateTimePicker',
            array(
                'model' => $this->model,
                'attribute' => $this->attribute,
                'options' => isset($options) ? $options : array(),
                'events' => isset($events) ? $events : array(),
                'htmlOptions' => $this->htmlOptions,
            )
        );
        echo $this->getAppend();
        echo $this->getError() . $this->getHint();
    }

	protected function setPlaceholder()
	{
		if (empty($this->htmlOptions['placeholder'])) {
			$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		}
	}
}
