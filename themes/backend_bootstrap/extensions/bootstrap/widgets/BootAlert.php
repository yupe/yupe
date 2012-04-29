<?php
/**
 * BootAlert class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright  Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

/**
 * Bootstrap alert widget.
 */
class BootAlert extends CWidget
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

		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->id;

		if (is_string($this->keys))
			$this->keys = array($this->keys);

		echo CHtml::openTag('div', $this->htmlOptions);

		foreach ($this->keys as $key)
		{
			if (Yii::app()->user->hasFlash($key))
			{
				echo strtr($this->template, array(
					'{class}'=>' fade in',
					'{key}'=>$key,
					'{message}'=>Yii::app()->user->getFlash($key),
				));
			}
		}

		echo '</div>';

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();
		$selector = "#{$id} .alert";
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('{$selector}').alert();");

		// Register the "close" event-handler.
		if (isset($this->events['close']))
		{
			$fn = CJavaScript::encode($this->events['close']);
			$cs->registerScript(__CLASS__.'#'.$id.'.close', "jQuery('{$selector}').bind('close', {$fn});");
		}

		// Register the "closed" event-handler.
		if (isset($this->events['closed']))
		{
			$fn = CJavaScript::encode($this->events['closed']);
			$cs->registerScript(__CLASS__.'#'.$id.'.closed', "jQuery('{$selector}').bind('closed', {$fn});");
		}
	}
}
