<?php
/**
 * BootListView class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('zii.widgets.CListView');

/**
 * Bootstrap list view.
 * Used to enable the bootstrap pager.
 */
class BootListView extends CListView
{
	/**
	 * @var string the CSS class name for the pager container. Defaults to 'pagination'.
	 */
	public $pagerCssClass = 'pagination';
	/**
	 * @var array the configuration for the pager.
	 */
	public $pager = array('class'=>'bootstrap.widgets.BootPager');
	/**
	 * @var string the URL of the CSS file used by this detail view.
	 * Defaults to false, meaning that no CSS will be included.
	 */
	public $cssFile = false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		$popover = Yii::app()->bootstrap->popoverSelector;
		$tooltip = Yii::app()->bootstrap->tooltipSelector;

		$afterAjaxUpdate = "js:function() {
			jQuery('.popover').remove();
			jQuery('{$popover}').popover();
			jQuery('.tooltip').remove();
			jQuery('{$tooltip}').tooltip();
		}";

		if (isset($this->afterAjaxUpdate))
			$this->afterAjaxUpdate .= ' '.$afterAjaxUpdate;
		else
			$this->afterAjaxUpdate = $afterAjaxUpdate;
	}


}
