<?php
/**
 * BootCarousel class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

Yii::import('bootstrap.widgets.BootWidget');

/**
 * Bootstrap carousel widget.
 */
class BootCarousel extends BootWidget
{
	/**
	 * @var string the previous button content.
	 */
	public $prev = '&lsaquo;';
	/**
	 * @var string the next button content.
	 */
	public $next = '&rsaquo;';
	/**
	 * @var array the carousel items configuration.
	 */
	public $items = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$cssClass = 'carousel';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$cssClass;
		else
			$this->htmlOptions['class'] = $cssClass;

		Yii::app()->bootstrap->registerCarousel();
	}

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		$id = $this->id;

		echo CHtml::openTag('div', $this->htmlOptions);
		echo '<div class="carousel-inner">';
		$this->renderItems($this->items);
		echo '</div>';
		echo '<a class="carousel-control left" href="#'.$id.'" data-slide="prev">'.$this->prev.'</a>';
		echo '<a class="carousel-control right" href="#'.$id.'" data-slide="next">'.$this->next.'</a>';
		echo '</div>';

		/** @var CClientScript $cs */
		$cs = Yii::app()->getClientScript();
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('{$id}').carousel({$options});");

        // Register the "slide" event-handler.
        if (isset($this->events['slide']))
        {
            $fn = CJavaScript::encode($this->events['slide']);
	        $cs->registerScript(__CLASS__.'#'.$this->id.'.slide',
	                "jQuery('#{$id}').on('slide', {$fn});");
        }

        // Register the "slid" event-handler.
        if (isset($this->events['slid']))
        {
            $fn = CJavaScript::encode($this->events['slid']);
	        $cs->registerScript(__CLASS__.'#'.$this->id.'.slid',
	                "jQuery('#{$id}').on('slid', {$fn});");
        }
	}

	/**
	 * Renders the carousel items.
	 * @param array $items the item configuration.
	 */
	protected function renderItems($items)
	{
		foreach ($items as $i => $item)
		{
			if (!isset($item['itemOptions']))
				$item['itemOptions'] = array();

			$class = array('item');

			if ($i === 0)
				$class[] = 'active';

			$cssClass = implode(' ', $class);
			if (isset($item['itemOptions']['class']))
				$item['itemOptions']['class'] .= ' '.$cssClass;
			else
				$item['itemOptions']['class'] = $cssClass;

			echo CHtml::openTag('div', $item['itemOptions']);

			if (isset($item['image']))
			{
				if (!isset($item['alt']))
					$item['alt'] = '';

				if (!isset($item['imageOptions']))
					$item['imageOptions'] = array();

				echo CHtml::image($item['image'], $item['alt'], $item['imageOptions']);
			}

			if (isset($item['label']) || isset($item['caption']))
			{
				if (!isset($item['captionOptions']))
					$item['captionOptions'] = array();

				$cssClass = 'carousel-caption';
				if (isset($item['captionOptions']['class']))
					$item['captionOptions']['class'] .= ' '.$cssClass;
				else
					$item['captionOptions']['class'] = $cssClass;

				echo CHtml::openTag('div', $item['captionOptions']);

				if (isset($item['label']))
					echo '<h4>'.$item['label'].'</h4>';

				if (isset($item['caption']))
					echo '<p>'.$item['caption'].'</p>';

				echo '</div>';
			}

			echo '</div>';
		}
	}
}
