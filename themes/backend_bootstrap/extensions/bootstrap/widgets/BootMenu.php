<?php
/**
 * BootMenu class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.BootBaseMenu');

/**
 * Bootstrap menu widget.
 * Used for rendering of bootstrap menus with support dropdown sub-menus and scroll-spying.
 * @since 0.9.8
 */
class BootMenu extends BootBaseMenu
{
	// Menu types.
	const TYPE_UNSTYLED = '';
	const TYPE_TABS = 'tabs';
	const TYPE_PILLS = 'pills';
	const TYPE_LIST = 'list';

	/**
	 * @var string the menu type.
	 * Valid values are '', 'tabs' and 'pills'. Defaults to ''.
	 */
	public $type = self::TYPE_UNSTYLED;
	/**
	 * @var boolean whether to stack navigation items.
	 */
	public $stacked = false;
	/**
	 * @var array the scroll-spy configuration.
	 */
	public $scrollspy;
	/**
	 * @var array the HTML options for dropdown menus.
	 */
	public $dropdownOptions = array();

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		$route = $this->controller->getRoute();
		$this->items = $this->normalizeItems($this->items, $route);

		$classes = array('nav');

		$validTypes = array(self::TYPE_UNSTYLED, self::TYPE_TABS, self::TYPE_PILLS, self::TYPE_LIST);

		if (!empty($this->type) && in_array($this->type, $validTypes))
			$classes[] = 'nav-'.$this->type;

		if ($this->type !== self::TYPE_LIST && $this->stacked)
			$classes[] = 'nav-stacked';

		$classes = implode(' ', $classes);
		if (isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] .= ' '.$classes;
		else
			$this->htmlOptions['class'] = $classes;

		if (isset($this->scrollspy) && is_array($this->scrollspy) && isset($this->scrollspy['spy']))
		{
			if (!isset($this->scrollspy['subject']))
				$this->scrollspy['subject'] = 'body';

			if (!isset($this->scrollspy['offset']))
				$this->scrollspy['offset'] = null;

			Yii::app()->bootstrap->spyOn($this->scrollspy['subject'], $this->scrollspy['spy'], $this->scrollspy['offset']);
		}
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
				echo '<li class="divider-vertical"></li>';
			else
			{
				if (!isset($item['itemOptions']))
					$item['itemOptions'] = array();

				$classes = array();

				if ($item['active'] || (isset($item['items']) && $this->isChildActive($item['items'])))
					$classes[] = 'active';

				if ($this->type === self::TYPE_LIST && !isset($item['url']))
				{
					$item['header'] = true;
					$classes[] = 'nav-header';
				}

				if (isset($item['items']))
					$classes[] = 'dropdown';

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

				if(isset($item['items']) && !empty($item['items']))
				{
					$this->controller->widget('bootstrap.widgets.BootDropdown', array(
						'encodeLabel'=>$this->encodeLabel,
						'items'=>$item['items'],
						'htmlOptions'=>isset($item['dropdownOptions']) ? $item['dropdownOptions'] : $this->dropdownOptions,
					));
				}

				echo '</li>';
			}
		}
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

		if (isset($item['items']) && !empty($item['items']))
		{
			if (isset($item['linkOptions']['class']))
				$item['linkOptions']['class'] .= ' dropdown-toggle';
			else
				$item['linkOptions']['class'] = 'dropdown-toggle';

			$item['linkOptions']['data-toggle'] = 'dropdown';
			$item['label'] .= ' <span class="caret"></span>';
		}

		return parent::renderItem($item);
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

			if (!empty($item['items']) && is_array($item['items']))
			{
				$items[$i]['items'] = $this->normalizeItems($item['items'], $route);

				if (empty($items[$i]['items']))
					unset($items[$i]['items']);
			}

			if (!isset($item['active']))
				$items[$i]['active'] = $this->isItemActive($item, $route);
		}

		return array_values($items);
	}

	/**
	 * Returns whether a child item is active.
	 * @param array $items the items to check
	 * @return boolean the result
	 */
	protected function isChildActive($items)
	{
		foreach ($items as $item)
			if (isset($item['active']) && $item['active'] === true)
				return true;

		return false;
	}
}
