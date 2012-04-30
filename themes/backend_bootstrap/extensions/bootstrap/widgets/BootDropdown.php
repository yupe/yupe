<?php
/**
 * BootDropdown class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 0.9.10
 */

Yii::import('bootstrap.widgets.BootBaseMenu');

/**
 * Bootstrap dropdown menu widget.
 */
class BootDropdown extends BootBaseMenu
{
	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$route = $this->controller->getRoute();
		$this->items = $this->normalizeItems($this->items, $route);

		$classes = 'dropdown-menu';
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;
	}

	/**
	 * Renders the items in this menu.
	 * @param array $items the menu items
	 */
	public function renderItems($items)
	{
		foreach ($items as $item)
		{
			if (!is_array($item))
				echo '<li class="divider"></li>';
			else
			{
				if (!isset($item['itemOptions']))
					$item['itemOptions'] = array();

				$classes = array();
				if (!isset($item['url']))
				{
					$item['header'] = true;
					$classes[] = 'nav-header';
				}

				if ($item['active'])
					$classes[] = 'active';

				$classes = implode(' ', $classes);
				if(isset($item['itemOptions']['class']))
					$item['itemOptions']['class'] .= ' '.$classes;
				else
					$item['itemOptions']['class'] = $classes;

				echo CHtml::openTag('li', $item['itemOptions']);
				$menu = $this->renderItem($item);

				if (isset($this->itemTemplate) || isset($item['template']))
				{
					$template = isset($item['template']) ? $item['template'] : $this->itemTemplate;
					echo strtr($template, array('{menu}'=>$menu));
				}
				else
					echo $menu;

				echo '</li>';
			}
		}
	}

	/**
	 * Normalizes the items in this menu.
	 * @param array $items the items to be normalized
	 * @param string $route the route of the current request
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items, $route)
	{
		foreach ($items as $i => $item)
		{
			if (!is_array($item))
				continue;

			if (isset($item['visible']) && !$item['visible'])
			{
				unset($items[$i]);
				continue;
			}

			if (!is_array($item)) {
				continue;
			}

			if (!isset($item['label']))
				$item['label'] = '';

			if (isset($item['encodeLabel']) && $item['encodeLabel'])
				$items[$i]['label'] = CHtml::encode($item['label']);

			if (($this->encodeLabel && !isset($item['encodeLabel']))
					|| (isset($item['encodeLabel']) && $item['encodeLabel'] !== false))
				$items[$i]['label'] = CHtml::encode($item['label']);

			if (!isset($item['active']))
				$items[$i]['active'] = $this->isItemActive($item, $route);
		}

		return array_values($items);
	}
}
