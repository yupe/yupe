<?php

/**
 * Класс MenuWidget - виджет вывода меню на страницы сайта
 *
 * @package menu.widgets
 * @author yupe team
 * @link http://yupe.ru
 */

/**
 * Данный плагин реализует вывод меню модуля Menu.
 * 
 * Подключение виджета:
 * <?php
 * $this->widget('application.modules.menu.widgets.MenuWidget', array(
 *     'name' => 'top-menu',
 *     'params' => array('hideEmptyItems' => true),
 *     'layoutParams' => array('htmlOptions' => array(
 *         'class' => 'jqueryslidemenu',
 *         'id' => 'myslidemenu',
 *      )),
 * ));
 * ?>
 */
 
class MenuWidget extends YWidget
{
    /**
     * @var string данный параметр указывает уникальный код выводимого меню.
     */
    public $name;
    /**
     * @var string данный параметр указывает начиная с id какого родителя начинать вывод меню, по умолчанию 0, корень меню.
     */
    public $parent_id    = 0;
    /**
     * string данный параметр указывает название layout.
     */
    public $layout       = 'main';
    /**
     * @var array особенные параметры передаваемые в layout.
     */
    public $layoutParams = array();
    /**
     * @var array параметры виджета zii.widgets.CMenu.
     */
    public $params       = array();

    public function run()
    {
        $this->params['items'] = Menu::model()->getItems($this->name, $this->parent_id);
        $this->render($this->layout, array(
            'params'       => $this->params,
            'layoutParams' => $this->layoutParams,
        ));
    }
}