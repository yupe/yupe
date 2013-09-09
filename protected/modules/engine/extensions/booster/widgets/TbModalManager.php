<?php
/**
 * TbModalMaster class file.
 * @author Thiago Otaviani Vidal <thiagovidal@gmail.com>
 * @copyright Copyright &copy; Thiago Otaviani Vidal 2012
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.3
 */

/**
 * Bootstrap modal master widget.
 * @see https://github.com/jschr/bootstrap-modal/
 */
class TbModalManager extends CWidget
{
	/**
	 * @var boolean indicates whether to automatically open the modal when initialized. Defaults to 'false'.
	 */
	public $autoOpen = false;

	/**
	 * @var boolean indicates whether the modal should use transitions. Defaults to 'true'.
	 */
	public $fade = true;

	/**
	 * @var array the options for the Bootstrap Javascript plugin.
	 */
	public $options = array();

	/**
	 * @var string[] the Javascript event handlers.
	 */
	public $events = array();

	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id'])) {
			$this->htmlOptions['id'] = $this->getId();
		}

		if ($this->autoOpen === false && !isset($this->options['show'])) {
			$this->options['show'] = false;
		}

		$classes = array('modal');

		if ($this->fade === true) {
			$classes[] = 'fade';
		}

		if (!empty($classes)) {
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class'])) {
				$this->htmlOptions['class'] .= ' ' . $classes;
			} else {
				$this->htmlOptions['class'] = $classes;
			}
		}
		echo CHtml::openTag('div', $this->htmlOptions);
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::closeTag('div');
		$this->registerClientScript($this->htmlOptions['id']);
	}

	/**
	 * Registers required
	 *
	 * @param integer $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetJs('bootstrap-modalmanager.js', CClientScript::POS_HEAD);
		Yii::app()->bootstrap->registerAssetCss('bootstrap-modalmanager.css');

		$options = !empty($this->format) ? CJavaScript::encode(array('format' => $this->format)) : '';

		ob_start();
		echo "jQuery('#{$id}').modalmanager({$options})";
		foreach ($this->events as $event => $handler) {
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
		}

		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');

		foreach ($this->events as $name => $handler) {
			$handler = CJavaScript::encode($handler);
			Yii::app()->getClientScript()->registerScript(
				__CLASS__ . '#' . $id . '_' . $name,
				"jQuery('#{$id}').on('{$name}', {$handler});"
			);
		}
	}
}
