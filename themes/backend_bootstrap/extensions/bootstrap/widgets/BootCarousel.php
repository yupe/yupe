<?php
/**
 * BootCarousel class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

/**
 * Bootstrap carousel widget.
 */
class BootCarousel extends CWidget
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
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();

		$classes = 'carousel';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

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
	        $cs->registerScript(__CLASS__.'#'.$id.'.slide', "jQuery('#{$id}').on('slide', {$fn});");
        }

        // Register the "slid" event-handler.
        if (isset($this->events['slid']))
        {
            $fn = CJavaScript::encode($this->events['slid']);
	        $cs->registerScript(__CLASS__.'#'.$id.'.slid', "jQuery('#{$id}').on('slid', {$fn});");
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
			if (!is_array($item))
				continue;

			if (!isset($item['itemOptions']))
				$item['itemOptions'] = array();

			$classes = array('item');

			if ($i === 0)
				$classes[] = 'active';

			$classes = implode(' ', $classes);
			if (isset($item['itemOptions']['class']))
				$item['itemOptions']['class'] .= ' '.$classes;
			else
				$item['itemOptions']['class'] = $classes;

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

				$classes = 'carousel-caption';
				if (isset($item['captionOptions']['class']))
					$item['captionOptions']['class'] .= ' '.$classes;
				else
					$item['captionOptions']['class'] = $classes;

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
