<?php
/**
 * BootBaseMenu class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootWidget');

abstract class BootBaseMenu extends BootWidget
{
	/**
	 * @var array the menu items.
	 */
	public $items = array();
	/**
	 * @var string the item template.
	 */
	public $itemTemplate;
	/**
	 * @var boolean whether to encode item labels.
	 */
	public $encodeLabel = true;

	/**
	 * Runs the widget.
	 */
	public function run()
	{
		echo CHtml::openTag('ul', $this->htmlOptions);
		$this->renderItems($this->items);
		echo '</ul>';
	}

	/**
	 * Renders a single item in the menu.
	 * @param array $item the item configuration
	 * @return string the rendered item
	 */
	protected function renderItem($item)
	{
		if (!isset($item['linkOptions']))
			$item['linkOptions'] = array();

		if (isset($item['icon']))
		{
			if (strpos($item['icon'], 'icon') === false)
			{
				$pieces = explode(' ', $item['icon']);
                $item['icon'] = 'icon-'.implode(' icon-', $pieces);
			}

			$item['label'] = '<i class="'.$item['icon'].'"></i> '.$item['label'];
		}

		if (!isset($item['header']) && !isset($item['url']))
			$item['url'] = '#';

		if (isset($item['url']))
			return CHtml::link($item['label'], $item['url'], $item['linkOptions']);
		else
			return $item['label'];
	}

	/**
	 * Checks whether a menu item is active.
	 * @param array $item the menu item to be checked
	 * @param string $route the route of the current request
	 * @return boolean the result
	 */
	protected function isItemActive($item, $route)
	{
		if (isset($item['url']) && is_array($item['url']) && !strcasecmp(trim($item['url'][0], '/'), $route))
		{
			if (count($item['url']) > 1)
				foreach (array_splice($item['url'], 1) as $name=>$value)
					if (!isset($_GET[$name]) || $_GET[$name] != $value)
						return false;

			return true;
		}

		return false;
	}

	/**
	 * Renders the items in this menu.
	 * @abstract
	 * @param array $items the menu items
	 */
	abstract public function renderItems($items);
}
