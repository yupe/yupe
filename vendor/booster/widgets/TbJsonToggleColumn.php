<?php
/*##  TbButtonColumn class file.
 *
 * @author Konstantin Popov <popovconstantine@gmail.com>
 * @copyright  Copyright &copy; Konstantin Popov 2013-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php) 
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.TbToggleColumn');

/**
 * Bootstrap toggle button column widget.
 * Used to set buttons to use Glyphicons instead of the defaults images.
 */
class TbJsonToggleColumn extends TbToggleColumn
{
	
	/**
	 * Renders the data cell content.
	 * This method renders the view, update and toggle buttons in the data cell.
	 *
	 * @param integer $row the row number (zero-based)
	 * @return array|void
	 */
	public function renderDataCell($row)
	{
		if ($this->grid->json) {
			$data = $this->grid->dataProvider->data[$row];
			$col = array();
			ob_start();
			$this->renderDataCellContent($row, $data);
			$col['content'] = ob_get_contents();
			ob_end_clean();
			$col['attrs'] = '';
			return $col;

		}

		parent::renderDataCell($row);
	}

	/**
	 * Initializes the default toggle button.
	 */
	protected function initButton()
	{
		parent::initButton();
		/**
		 * add custom with msgbox instead
		 */
		$this->button['click'] = strtr(
			$this->button['click'],
			array('yiiGridView' => 'yiiJsonGridView')
		);
	}
	
}
