<?php
/**
 * BootInputSearch class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

Yii::import('bootstrap.widgets.input.BootInputInline');

/**
 * Bootstrap vertical form input widget.
 * @since 0.9.8
 */
class BootInputSearch extends BootInputInline
{
	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField()
	{
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' search-query';
		else
			$this->htmlOptions['class'] = 'search-query';

		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getError().$this->getHint();
	}
}
