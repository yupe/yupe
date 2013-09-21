<?php
/**
 *## TbInputSearch class file.
 *
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

Yii::import('bootstrap.widgets.input.TbInputInline');

/**
 *## TbInputSearch class
 *
 * Bootstrap vertical form input widget.
 *
 * @since 0.9.8
 * @package booster.widgets.forms.inputs
 */
class TbInputSearch extends TbInputInline
{
	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function searchField()
	{
		if (isset($this->htmlOptions['class'])) {
			$this->htmlOptions['class'] .= ' search-query';
		} else {
			$this->htmlOptions['class'] = 'search-query';
		}

		$this->setPlaceholder();
		echo $this->getPrepend();
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
		echo $this->getError() . $this->getHint();
	}
}
