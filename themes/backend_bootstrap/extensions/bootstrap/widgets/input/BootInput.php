<?php
/**
 * BootInput class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

/**
 * Bootstrap input widget.
 * Used for rendering inputs according to Bootstrap standards.
 */
abstract class BootInput extends CInputWidget
{
	// The different input types.
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_CHECKBOXLIST = 'checkboxlist';
	const TYPE_CHECKBOXLIST_INLINE = 'checkboxlist_inline';
	const TYPE_DROPDOWN = 'dropdownlist';
	const TYPE_FILE = 'filefield';
	const TYPE_PASSWORD = 'password';
	const TYPE_RADIO = 'radiobutton';
	const TYPE_RADIOLIST = 'radiobuttonlist';
	const TYPE_RADIOLIST_INLINE = 'radiobuttonlist_inline';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_TEXT = 'textfield';
	const TYPE_CAPTCHA = 'captcha';
	const TYPE_UNEDITABLE = 'uneditable';

	/**
	 * @var BootActiveForm the associated form widget.
	 */
	public $form;
	/**
	 * @var string the input label text.
	 */
	public $label;
	/**
	 * @var string the input type.
	 * Following types are supported: checkbox, checkboxlist, dropdownlist, filefield, password,
	 * radiobutton, radiobuttonlist, textarea, textfield, captcha and uneditable.
	 */
	public $type;
	/**
	 * @var array the data for list inputs.
	 */
	public $data = array();

	/**
	 * Initializes the widget.
	 * @throws CException if the widget could not be initialized.
	 */
	public function init()
	{
		if (!isset($this->form))
			throw new CException(__CLASS__.': Failed to initialize widget! Form is not set.');

		if (!isset($this->model))
			throw new CException(__CLASS__.': Failed to initialize widget! Model is not set.');

		if (!isset($this->type))
			throw new CException(__CLASS__.': Failed to initialize widget! Input type is not set.');

		if ($this->type === self::TYPE_UNEDITABLE)
		{
			$classes = 'uneditable-input';
			if (isset($this->htmlOptions['class']))
				$this->htmlOptions['class'] .= ' '.$classes;
			else
				$this->htmlOptions['class'] = $classes;
		}
	}

	/**
	 * Runs the widget.
	 * @throws CException if the widget type is invalid.
	 */
	public function run()
	{
		switch ($this->type)
		{
			case self::TYPE_CHECKBOX:
				$this->checkBox();
				break;

			case self::TYPE_CHECKBOXLIST:
				$this->checkBoxList();
				break;

			case self::TYPE_CHECKBOXLIST_INLINE:
				$this->checkBoxListInline();
				break;

			case self::TYPE_DROPDOWN:
				$this->dropDownList();
				break;

			case self::TYPE_FILE:
				$this->fileField();
				break;

			case self::TYPE_PASSWORD:
				$this->passwordField();
				break;

			case self::TYPE_RADIO:
				$this->radioButton();
				break;

			case self::TYPE_RADIOLIST:
				$this->radioButtonList();
				break;

			case self::TYPE_RADIOLIST_INLINE:
				$this->radioButtonListInline();
				break;

			case self::TYPE_TEXTAREA:
				$this->textArea();
				break;

			case self::TYPE_TEXT:
				$this->textField();
				break;

			case self::TYPE_CAPTCHA:
				$this->captcha();
				break;

			case self::TYPE_UNEDITABLE:
				$this->uneditableField();
				break;

			default:
				throw new CException(__CLASS__.': Failed to run widget! Type is invalid.');
		}
	}

	/**
	 * Returns the label for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the label
	 */
	protected function getLabel($htmlOptions = array())
	{
		if ($this->label !== false && !in_array($this->type, array('checkbox', 'radio')) && $this->hasModel())
			return $this->form->labelEx($this->model, $this->attribute, $htmlOptions);
		else if ($this->label !== null)
			return $this->label;
		else
			return '';
	}

	/**
	 * Returns the prepend element for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the element
	 */
	protected function getPrepend($htmlOptions = array())
	{
		if ($this->hasAddOn())
		{
			$classes = 'add-on';
			if (isset($htmlOptions['class']))
				$htmlOptions['class'] .= ' '.$classes;
			else
				$htmlOptions['class'] = $classes;

			$classes = $this->getInputContainerCssClass();
			ob_start();
			echo '<div class="'.$classes.'">';
			if (isset($this->htmlOptions['prepend']))
				echo CHtml::tag('span', $htmlOptions, $this->htmlOptions['prepend']);
			return ob_get_clean();
		}
		else
			return '';
	}

	/**
	 * Returns the append element for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the element
	 */
	protected function getAppend($htmlOptions = array())
	{
		if ($this->hasAddOn())
		{
			$classes = 'add-on';
			if (isset($htmlOptions['class']))
				$htmlOptions['class'] .= ' '.$classes;
			else
				$htmlOptions['class'] = $classes;

			ob_start();
			if (isset($this->htmlOptions['append']))
				echo CHtml::tag('span', $htmlOptions, $this->htmlOptions['append']);
			echo '</div>';
			return ob_get_clean();
		}
		else
			return '';
	}

	/**
	 * Returns the input container CSS classes.
	 * @return string the classes
	 */
	protected function getInputContainerCssClass()
	{
		$classes = array();
		if (isset($this->htmlOptions['prepend']))
			$classes[] = 'input-prepend';
		if (isset($this->htmlOptions['append']))
			$classes[] = 'input-append';

		return implode(' ', $classes);
	}

	/**
	 * Returns whether the input has an add-on (prepend and/or append).
	 * @return boolean the result
	 */
	protected function hasAddOn()
	{
		return isset($this->htmlOptions['prepend']) || isset($this->htmlOptions['append']);
	}

	/**
	 * Returns the error text for the input.
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the error text
	 */
	protected function getError($htmlOptions = array())
	{
		return $this->form->error($this->model, $this->attribute, $htmlOptions);
	}

	/**
	 * Returns the hint text for the input.
	 * @return string the hint text
	 */
	protected function getHint()
	{
		if (isset($this->htmlOptions['hint']))
		{
			$hint = $this->htmlOptions['hint'];
			unset($this->htmlOptions['hint']);
			return '<p class="help-block">'.$hint.'</p>';
		}
		else
			return '';
	}

	/**
	 * Returns the container CSS class for the input.
	 * @return string the CSS class.
	 */
	protected function getContainerCssClass()
	{
		if ($this->model->hasErrors(CHtml::resolveName($this->model, $this->attribute)))
			return CHtml::$errorCss;
		else
			return '';
	}

	/**
	 * Renders a checkbox.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBox();

	/**
	 * Renders a list of checkboxes.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBoxList();

	/**
	 * Renders a list of inline checkboxes.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function checkBoxListInline();

	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function dropDownList();

	/**
	 * Renders a file field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function fileField();

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function passwordField();

	/**
	 * Renders a radio button.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButton();

	/**
	 * Renders a list of radio buttons.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButtonList();

	/**
	 * Renders a list of inline radio buttons.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function radioButtonListInline();

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function textArea();

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function textField();

	/**
	 * Renders a CAPTCHA.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function captcha();

	/**
	 * Renders an uneditable field.
	 * @return string the rendered content
	 * @abstract
	 */
	abstract protected function uneditableField();
}
