<?php
/**
 * Класс YWidget - базовый класс для всех виджетов Юпи!
 *
 * Все виджеты Юпи! должны наследовать этот класс
 * Основная особенность - view файлы для виджетов хранятся в каталоге "widgets" текущей темы, подробнее https://github.com/yupe/yupe/issues/26
 *
 * @package yupe.core.widgets
 * @abstract
 * @author  yupe team
 * @link    http://yupe.ru
 *
 */

abstract class YWidget extends CWidget
{
    /**
     * cacheTime - время кэширования выборки в виджете
     * если передано 0 - выборка не кэшируется, если ничего не передано - берется время жизни кэша из ядра:
     * Yii::app()->getModule('yupe')->coreCacheTime
     *
     */
    public $cacheTime;
    public $limit = 5;

    public function init()
    {
        parent::init();

        //if (!$this->cacheTime && $this->cacheTime !== 0)
        //$this->cacheTime = Yii::app()->getModule('yupe')->coreCacheTime;
    }

    /**
     * Looks for the view script file according to the view name.
     * If application uses theme, its method {@link YTheme::getWidgetViewFile()} will be used to search view file
     * under theme view files path according to theme's rules. Otherwise, parent implementation of this method will be used.
     *
     * @see YTheme::getWidgetViewFile()
     * @see CWidget::getViewFile()
     *
     * @param string $viewName Name of the view (without file extension).
     *
     * @return bool|string The view file path. False if the view file does not exist.
     */
    public function getViewFile($viewName)
    {
        if (
            (class_exists('YTheme', false) && ($theme = Yii::app()->theme) instanceof YTheme)
            &&
            ($viewFile = $theme->getWidgetViewFile($this, $viewName)) !== false
        ) {
            return $viewFile;
        } else {
            return parent::getViewFile($viewName);
        }
    }

    /**
     * @return string|null ID of module, that widget belongs to. Null if no module was found.
     */
    public function getModuleID()
    {
        $widgetReflection = new ReflectionClass(get_class($this));
        // @todo нужно переписать, непонятно как этот код работает. Код пишется для людей.
        $string = explode('modules' . DIRECTORY_SEPARATOR, $widgetReflection->getFileName(), 2);
        if (isset($string[1])) {
            $string = explode(DIRECTORY_SEPARATOR, $string[1], 2);
            return $string[0];
        }
        return null;
    }
}