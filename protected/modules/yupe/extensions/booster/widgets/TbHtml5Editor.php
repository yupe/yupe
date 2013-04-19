<?php
/**
 * TbHtml5Editor widget
 *
 * Implements the bootstrap-wysihtml5 editor
 *
 * @see https://github.com/jhollingworth/bootstrap-wysihtml5
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package YiiBooster bootstrap.widgets
 */
class TbHtml5Editor extends CInputWidget
{
	/**
	 * Editor language
	 * Supports: de-DE, es-ES, fr-FR, pt-BR, sv-SE
	 */
	public $lang = 'en';

	/**
	 * Html options that will be assigned to the text area
	 */
	public $htmlOptions = array();

	/**
	 * Editor options that will be passed to the editor
	 */
	public $editorOptions = array();

	/**
	 * Editor width
	 */
	public $width = '100%';

	/**
	 * Editor height
	 */
	public $height = '400px';

	/**
	 * Display editor
	 */
	public function run()
	{

		list($name, $id) = $this->resolveNameID();

		$this->registerClientScript($id);

		$this->htmlOptions['id'] = $id;

		if (!array_key_exists('style', $this->htmlOptions))
			$this->htmlOptions['style'] = "width:{$this->width};height:{$this->height};";
		// Do we have a model?
		if ($this->hasModel())
			echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			echo CHtml::textArea($name, $this->value, $this->htmlOptions);
	}

	/**
	 * Register required script files
	 * @param string $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetCss('bootstrap-wysihtml5.css');
		Yii::app()->bootstrap->registerAssetJs('wysihtml5-0.3.0.js');
		Yii::app()->bootstrap->registerAssetJs('bootstrap-wysihtml5.js');

		if (isset($this->editorOptions['locale']))
		{
			Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-wysihtml5.'.$this->editorOptions['locale'].'.js');
		}
		elseif (in_array($this->lang, array('de-DE','es-ES','fr','fr-NL','pt-BR','sv-SE')))
		{
			Yii::app()->bootstrap->registerAssetJs('locales/bootstrap-wysihtml5.'.$this->lang.'.js');
			$this->editorOptions['locale'] = $this->lang;
		}

		$this->normalizeStylesheetsProperty();
		$this->insertDefaultStylesheetIfColorsEnabled();

		$options = CJSON::encode($this->editorOptions);

		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id, "$('#{$id}').wysihtml5({$options});");
	}

	private function insertDefaultStylesheetIfColorsEnabled()
	{
		if (empty($this->editorOptions['color']))
			return;

		$defaultStyleSheetUrl = Yii::app()->bootstrap->getAssetsUrl() . '/css/wysiwyg-color.css';
		array_unshift( $this->editorOptions['stylesheets'], $defaultStyleSheetUrl ); // we want default css to be first
	}

	private function normalizeStylesheetsProperty()
	{
		if (empty($this->editorOptions['stylesheets']))
			$this->editorOptions['stylesheets'] = array();
		else if (is_array($this->editorOptions['stylesheets']))
			$this->editorOptions['stylesheets'] = array_filter($this->editorOptions['stylesheets'], 'is_string');
		else if (is_string($this->editorOptions['stylesheets']))
			$this->editorOptions['stylesheets'] = array($this->editorOptions['stylesheets']);
		else // presumably if this option is neither an array or string then it's some erroneous value; clean it
			$this->editorOptions['stylesheets'] = array();
	}
}
