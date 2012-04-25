<?php
/**
 * BootAlert class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap alert widget.
 * @todo Fix event support. http://twitter.github.com/bootstrap/javascript.html#alerts
 */
class BootAlert extends BootWidget
{
	/**
	 * @var array the keys for which to get flash messages.
	 */
	public $keys = array('success', 'info', 'warning', 'error', /* or */'danger');
	/**
	 * @var string the template to use for displaying flash messages.
	 */
	public $template = '<div class="alert alert-block alert-{key}{class}"><a class="close" data-dismiss="alert">&times;</a>{message}</div>';
	/**
	 * @var array the html options.
	 */
	public $htmlOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		Yii::app()->bootstrap->registerAlert();

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		if (is_string($this->keys))
			$this->keys = array($this->keys);

		echo CHtml::openTag('div', $this->htmlOptions);

		$transitions = Yii::app()->bootstrap->isPluginRegistered(Bootstrap::PLUGIN_TRANSITION);

		foreach ($this->keys as $key)
		{
			if (Yii::app()->user->hasFlash($key))
			{
				echo strtr($this->template, array(
					'{class}'=>$transitions ? ' fade in' : '',
					'{key}'=>$key,
					'{message}'=>Yii::app()->user->getFlash($key),
				));
			}
		}

		echo '</div>';

		$selector = "#{$this->id} .alert";
		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id, "jQuery('{$selector}').alert();");

		/*
		// Register the "close" event-handler.
		if (isset($this->events['close']))
		{
			$fn = CJavaScript::encode($this->events['close']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.close', "jQuery('{$selector}').bind('close', {$fn});");
		}

		// Register the "closed" event-handler.
		if (isset($this->events['closed']))
		{
			$fn = CJavaScript::encode($this->events['closed']);
			Yii::app()->clientScript->registerScript(__CLASS__.'#'.$this->id.'.closed', "jQuery('{$selector}').bind('closed', {$fn});");
		}
		*/
	}
}
