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
class BootModal extends BootWidget
{
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		Yii::app()->bootstrap->registerModal();

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$class = array('modal');

		if (Yii::app()->bootstrap->isPluginRegistered(Bootstrap::PLUGIN_TRANSITION))
			$class[] = 'fade';

		$cssClass = implode(' ', $class);
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$cssClass;
		else
			$this->htmlOptions['class'] = $cssClass;



		echo CHtml::openTag('div', $this->htmlOptions).PHP_EOL;
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo '</div>';

		// Register the "show" event-handler.
		if (isset($this->events['show']))
		{
			$fn = CJavaScript::encode($this->events['show']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.show',
					"jQuery('#{$this->id}').on('show', {$fn});");
		}

		// Register the "shown" event-handler.
		if (isset($this->events['shown']))
		{
			$fn = CJavaScript::encode($this->events['shown']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.shown',
					"jQuery('#{$this->id}').on('shown', {$fn});");
		}

		// Register the "hide" event-handler.
		if (isset($this->events['hide']))
		{
			$fn = CJavaScript::encode($this->events['hide']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.hide',
					"jQuery('#{$this->id}').on('hide', {$fn});");
		}

		// Register the "hidden" event-handler.
		if (isset($this->events['hidden']))
		{
			$fn = CJavaScript::encode($this->events['hidden']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.hidden',
					"jQuery('#{$this->id}').on('hidden', {$fn});");
		}
	}
}
