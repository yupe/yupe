<?php
/**
 * Виджет панели быстрого запуска:
 *
 * @category YupeWidget
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class YShortCuts extends YWidget
{
    public $shortcuts;
    private $_baseShortCutClass = 'shortcut';
    
    /**
     * Запуск виджета
     *
     * @return void
     **/
    public function run()
    {
        $this->render('yupe.views.widgets.YShortCuts.shortcuts');
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
            ? 'icon-'.implode(' icon-', explode(' ', $icon))
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
        return CHtml::tag('i', array('class' => "shortcut-icon " . $this->getIcons($shortcut['icon'])), '')
             . CHtml::tag('span', array('class' => 'shortcut-label'), $shortcut['label']);
    }
}