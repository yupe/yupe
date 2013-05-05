<?php
/**
 * YiiDebugToolbarPanel class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanel represents an ...
 *
 * Description of YiiDebugToolbarPanel
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
abstract class YiiDebugToolbarPanel extends CWidget
implements YiiDebugToolbarPanelInterface
{

    const VIEWS_PATH = '/views/panels';

    private $_enabled = true;

    /**
     * @param boolean $value set is panel enabled
     */
    public function setEnabled($value)
    {
        $this->_enabled = CPropertyValue::ensureBoolean($value);
    }

    /**
     * @return boolean $value is panel enabled
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Displays a variable.
     * This method achieves the similar functionality as var_dump and print_r
     * but is more robust when handling complex objects such as Yii controllers.
     * @param mixed $var variable to be dumped
     */
    public function dump($var)
    {
        YiiDebug::dump($var);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubTitle()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSubTitle()
    {
        return null;
    }

    /**
     * Returns the directory containing the view files for this widget.
     * @param boolean $checkTheme not implemented. Only for inheriting CWidget interface.
     * @return string the directory containing the view files for this widget.
     */
    public function getViewPath($checkTheme = false)
    {
        return dirname(__FILE__) . self::VIEWS_PATH;
    }

}
