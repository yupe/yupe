<?php
namespace yupe\widgets;

use Yii;
use CHtml;

Yii::import('booster.widgets.TbToggleColumn');

class ToggleColumn extends \TbToggleColumn
{
    /**
     * @var string the glyph icon toggle button "checked" state.
     * You may set this property to be false to render a text link instead.
     */
    public $checkedIcon = 'fa fa-fw fa-check-circle';

    /**
     * @var string the glyph icon toggle button "unchecked" state.
     * You may set this property to be false to render a text link instead.
     */
    public $uncheckedIcon = 'fa fa-fw fa-times-circle';

    /**
     * @var string the glyph icon toggle button "empty" state (example for null value)
     */
    public $emptyIcon = 'fa fa-fw fa-question-circle';

    /**
     * Renders the data cell content.
     * This method renders the view, update and toggle buttons in the data cell.
     *
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {

        $checked = ($this->value === null)
            ? CHtml::value($data, $this->name)
            : $this->evaluateExpression($this->value, array('data' => $data, 'row' => $row));

        $button = $this->button;
        $button['icon'] = $checked === null ? $this->emptyIcon : ($checked ? $this->checkedIcon : $this->uncheckedIcon);
        $button['url'] = isset($button['url']) ? $this->evaluateExpression(
            $button['url'],
            array('data' => $data, 'row' => $row)
        ) : '#';

        if (!$this->displayText) {
            $button['htmlOptions']['title'] = $this->getButtonLabel($checked);
            if (!isset($button['htmlOptions']['data-toggle'])) {
                $button['htmlOptions']['data-toggle'] = 'tooltip';
            }
            echo CHtml::link('<i class="' . $button['icon'] . '"></i>', $button['url'], $button['htmlOptions']);
        } else {
            $button['label'] = $this->getButtonLabel($checked);
            $button['class'] = 'booster.widgets.TbButton';
            $button['buttonType'] = 'link';
            $widget = Yii::createComponent($button);
            $widget->init();
            $widget->run();
        }
    }

    private function getButtonLabel($value)
    {

        return $value === null ? $this->emptyButtonLabel : ($value ? $this->checkedButtonLabel : $this->uncheckedButtonLabel);
    }
}