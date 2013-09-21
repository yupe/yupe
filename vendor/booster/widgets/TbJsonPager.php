<?php
/**
 *## TbJsonPager class file.
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 */

Yii::import('bootstrap.widgets.TbPager');

/**
 *## Class TbJsonPager
 *
 * Use this specific pager for JSON grid, not the standard one!
 *
 * @package booster.widgets.supplementary
 */
class TbJsonPager extends TbPager
{
	/**
	 * @var string json.
	 */
	public $json;

	/**
	 *### .run()
	 *
	 * Runs the widget.
	 */
	public function run()
	{
		if (!$this->json) {
			parent::run();
		}

		return $this->createPageButtons();
	}

	/**
	 *### .createPageButton()
	 *
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 *
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 *
	 * @return string the generated button
	 */
	protected function createPageButton($label, $page, $class, $hidden, $selected)
	{
		if ($this->json) {
			if ($hidden || $selected) {
				$class .= ' ' . ($hidden ? 'disabled' : 'active');
			}
			return array('class' => $class, 'url' => $this->createPageUrl($page), 'text' => $label);
		}
		return parent::createPageButton($label, $page, $class, $hidden, $selected);
	}
}
