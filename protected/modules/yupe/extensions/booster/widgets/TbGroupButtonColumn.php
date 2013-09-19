<?php
/**
 *## TbGroupButtonColumn class file.
 *
 * @author Lushnikov Alexander <alexander.aka.alegz@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @since 0.9.8
 */

Yii::import('zii.widgets.grid.CButtonColumn');

/**
 *## Bootstrap button column widget.
 *
 * Used to set buttons group.
 *
 * @package booster.widgets.grids.columns
 */
class TbGroupButtonColumn extends CButtonColumn
{
	/**
	 * Renders a link button.
	 *
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id, $button, $row, $data)
	{
		if (isset($button['visible']) && !$this->evaluateExpression(
			$button['visible'],
			array('row' => $row, 'data' => $data)
		)
		) {
			return;
		}

		$label = isset($button['label']) ? $button['label'] : $id;
		$url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data' => $data, 'row' => $row))
			: '#';
		$options = isset($button['options']) ? $button['options'] : array();

		if (!isset($options['title'])) {
			$options['title'] = $label;
		}

		//Forsing btn class
		if (!isset($options['class'])) {
			$options['class'] = 'btn';
		} else if (!preg_match('/[^A-z\-]btn[^A-z\-]/', $options['class'])) {
			$options['class'] = 'btn ' . $options['class'];
		}

		if (isset($button['icon'])) {
			if (strpos($button['icon'], 'icon') === false) {
				$button['icon'] = 'icon-' . implode(' icon-', explode(' ', $button['icon']));
			}

			echo CHtml::link('<i class="' . $button['icon'] . '"></i>', $url, $options);
		} else {
			echo CHtml::link($label, $url, $options);
		}
	}

	/**
	 * Renders the data cell content.
	 * This method renders the view, update and delete buttons in the data cell.
	 *
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data associated with the row
	 */
	protected function renderDataCellContent($row, $data)
	{
		$tr = array();
		ob_start();
		foreach ($this->buttons as $id => $button) {
			$this->renderButton($id, $button, $row, $data);
			$tr['{' . $id . '}'] = ob_get_contents();
			ob_clean();
		}

		ob_end_clean();
		echo '<div class="btn-group">';
		echo strtr($this->template, $tr);
		echo '</div>';
	}
}
