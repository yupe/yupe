<?php

/**
 * Класс MenuWidget - виджет вывода меню на страницы сайта
 *
 * @package yupe.modules.menu.widgets
 * @author yupe team
 * @link https://yupe.ru
 */

/**
 * Виджет реализует вывод меню
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

Yii::import('application.modules.menu.models.*');

/**
 * Class MenuWidget
 */
class MenuWidget extends yupe\widgets\YWidget
{
    /**
     * @var string уникальный код выводимого меню
     */
    public $name;
    /**
     * @var string начиная с id какого родителя начинать вывод меню, по умолчанию 0, корень меню
     */
    public $parent_id = 0;
    /**
     * string данный параметр указывает название layout
     */
    public $view = 'main';
    /**
     * @var array особенные параметры передаваемые в layout
     */
    public $viewParams = [];
    /**
     * @var array параметры виджета zii.widgets.CMenu
     */
    public $params = [];

    /**
     * @throws CException
     */
    public function run()
    {
        $this->params['items'] = Menu::model()->getItems($this->name, $this->parent_id);
        $this->render(
            $this->view,
            [
                'params' => $this->params,
                'viewParams' => $this->viewParams,
            ]
        );
    }
}
