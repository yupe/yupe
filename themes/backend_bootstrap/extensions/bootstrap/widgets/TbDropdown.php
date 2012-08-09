<?php
/**
 * TbDropdown class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.TbBaseMenu');

/**
 * Bootstrap dropdown menu.
 * @see http://twitter.github.com/bootstrap/javascript.html#dropdowns
 */
class TbDropdown extends TbBaseMenu
{
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (isset($this->htmlOptions['class']))
            $this->htmlOptions['class'] .= ' dropdown-menu';
        else
            $this->htmlOptions['class'] = 'dropdown-menu';
    }

    /**
     * Returns the divider CSS class.
     * @return string the class name
     */
    public function getDividerCssClass()
    {
        return 'divider';
    }
}
