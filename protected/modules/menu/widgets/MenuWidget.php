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
 *     'id' => 'myslidemenu',
 *     'params' => array('hideEmptyItems' => true),
 *     'htmlOptions' => array('class' => 'jqueryslidemenu'),
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
    public $parent_id = 0;

    /**
     * @var array параметры виджета zii.widgets.CMenu.
     */
    public $params = array();
    /**
     * @var integer данная переменная задает id блока div оборачивающего меню.
     */
    public $id;
    /**
     * @var array htmlOptions тега div.
     */
    public $htmlOptions = array();
    /**
     * string данный параметр указывает название layout, если он не указан, меню выводится стандартные способом.
     */
    public $layout;
    /**
     * @var array параметры передаваемые в layout.
     */
    public $layoutParams = array();

    public function init()
    {
        parent::init();
        $this->parent_id = (int) $this->parent_id;
    }

    public function run()
    {
        $menu = $this->widget('zii.widgets.CMenu', ($this->params + array('items' => Menu::model()->getItems($this->name, $this->parent_id))), true);

        if (!$this->layout)
        {
            echo CHtml::openTag('div', (array('id' => $this->id) + $this->htmlOptions));
            echo $menu;
            echo CHtml::closeTag('div');
        }
        else
            $this->render($this->layout, (array('content' => $menu) + $this->$layoutParams));
    }
}