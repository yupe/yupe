<?php
/**
 * Виджет для отображения информации о модуле
 * Используется в панели управления
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
namespace yupe\widgets;

/**
 * Class YModuleInfo
 * @package yupe\widgets
 */
class YModuleInfo extends YWidget
{
    /**
     * @var
     */
    public $module;

    /**
     * @var string
     */
    public $view = 'moduleinfowidget';

    /**
     *
     */
    public function init()
    {
        if (!$this->module && is_object($this->controller->module)) {
            $this->module = $this->controller->module;
        }
    }

    /**
     *
     */
    public function run()
    {
        $this->render($this->view, ['module' => $this->module]);
    }
}
