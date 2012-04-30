<?php
/**
 * BootModal class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.3
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap modal widget.
 */
class BootModal extends CWidget
{
	/**
	 * @var boolean whether to automatically open the modal when initialized.
	 */
	public $autoOpen = false;
	/**
	 * @var array the options for the Bootstrap JavaScript plugin.
	 */
	public $options = array();
	/**
	 * @var string[] the JavaScript event handlers.
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
		parent::init();

		if (!$this->autoOpen && !isset($this->options['show']))
			$this->options['show'] = false;

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$classes = 'modal fade';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

		echo CHtml::openTag('div', $this->htmlOptions).PHP_EOL;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->id;

		echo '</div>';

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();

		$options = CJavaScript::encode($this->options);
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').modal({$options});");

		// Register the "show" event-handler.
		if (isset($this->events['show']))
		{
			$fn = CJavaScript::encode($this->events['show']);
			$cs->registerScript(__CLASS__.'#'.$id.'.show', "jQuery('#{$id}').on('show', {$fn});");
		}

		// Register the "shown" event-handler.
		if (isset($this->events['shown']))
		{
			$fn = CJavaScript::encode($this->events['shown']);
			$cs->registerScript(__CLASS__.'#'.$id.'.shown', "jQuery('#{$id}').on('shown', {$fn});");
		}

		// Register the "hide" event-handler.
		if (isset($this->events['hide']))
		{
			$fn = CJavaScript::encode($this->events['hide']);
			$cs->registerScript(__CLASS__.'#'.$id.'.hide', "jQuery('#{$id}').on('hide', {$fn});");
		}

		// Register the "hidden" event-handler.
		if (isset($this->events['hidden']))
		{
			$fn = CJavaScript::encode($this->events['hidden']);
			$cs->registerScript(__CLASS__.'#'.$id.'.hidden', "jQuery('#{$id}').on('hidden', {$fn});");
		}
	}
}
