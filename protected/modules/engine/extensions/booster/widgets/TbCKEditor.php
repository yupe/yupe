<?php
/*## TbCKEditor class file.
 *
 * Supports new CKEditor 4
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package bootstrap.widgets.input
 */
class TbCKEditor extends CInputWidget
{
	/**
	 * @var TbActiveForm when created via TbActiveForm
	 * This attribute is set to the form that renders the widget
	 * @see TbActionForm->inputRow
	 */
	public $form;

	/**
	 * @var array the CKEditor options
	 * @see <http://docs.cksource.com/>
	 * @since 10/30/12 10:40 AM the Editor used is CKEditor 4 Beta will be updated as final version is done
	 */
	public $editorOptions = array();

	/**
	 *### .run()
	 *
	 * Display editor
	 */
	public function run()
	{

		list($name, $id) = $this->resolveNameID();

		$this->registerClientScript($id);

		$this->htmlOptions['id'] = $id;

		// Do we have a model?
		if ($this->hasModel()) {
			if ($this->form) {
				$html = $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
			} else {
				$html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
			}
		} else {
			$html = CHtml::textArea($name, $this->value, $this->htmlOptions);
		}
		echo $html;
	}

	/**
	 *### .registerClientScript()
	 *
	 * Registers required javascript
	 *
	 * @param string $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetJs('ckeditor/ckeditor.js');

		$options = !empty($this->editorOptions) ? CJavaScript::encode($this->editorOptions) : '{}';

		Yii::app()->clientScript->registerScript(
			__CLASS__ . '#' . $this->getId(),
			"CKEDITOR.replace( '$id', $options);"
		);
	}
}
