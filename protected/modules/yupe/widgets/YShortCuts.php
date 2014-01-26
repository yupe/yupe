<?php
/**
 * Виджет панели быстрого запуска:
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
namespace yupe\widgets;
use CHtml;

class YShortCuts extends YWidget
{
    public $shortcuts;
    public $modules;
    public $updates;
    public $view = 'yupe.views.widgets.YShortCuts.shortcuts';
    private $_baseShortCutClass = 'shortcut';
    
    /**
     * Запуск виджета
     *
     * @return void
     **/
    public function run()
    {
        $this->render($this->view);
    }

    /**
     * Возвращаем иконки:
     *
     * @param string $icon - icon attribute
     *
     * @return string icons
     **/
    public function getIcons($icon)
    {
        return ($icons = explode(' ', $icon)) && count($icons) > 0
            ? 'fa-'.implode(' fa-', explode(' ', $icon))
            : '';
    }

    /**
     * Получаем htmlOptions:
     *
     * @param array $shortcut - массив эллемента
     *
     * @return array of htmlOptions
     **/
    public function getHtmlOptions($shortcut)
    {
        return array_merge(
            array(
                'class' => $this->_baseShortCutClass
                    . (
                        isset($shortcut['htmlOptions']) && isset($shortcut['htmlOptions']['class'])
                        ? ' ' . $shortcut['htmlOptions']['class']
                        : ''
                    )
            ),
            isset($shortcut['htmlOptions'])
            ? $shortcut['htmlOptions']
            : array()
        );
    }

    /**
     * Получаем label для анкора
     *
     * @param array $shortcut - массив эллемента
     *
     * @return string label for anchor
     **/
    public function getLabel($shortcut)
    {
        return CHtml::tag('i', array('class' => "shortcut-icon fa " . $this->getIcons($shortcut['icon'])), '')
             . CHtml::tag('span', array('class' => 'shortcut-label'), $shortcut['label']);
    }

    /**
     * Получаем обновления:
     */
    public function getUpdates($shortcut, $name)
    {
        $module = !isset($this->modules[$name])
            ? null
            : $this->modules[$name];

        return $module === null
            || !(
                    isset($this->updates[$name])
                    && count($this->updates[$name]) > 0
                )
            ? ''
            : "<span class='label label-info'><i class='fa fa-spin fa-repeat'></i>&nbsp;"
             . count($this->updates[$name])
             . "</span>";
    }
}