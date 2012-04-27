<?php
/**
 * Класс YWidget - базовый класс для всех виджетов Юпи!
 *
 * Все виджеты Юпи! должны наследовать этот класс
 * Основная особенность - view файлы для виджетов хранятся в каталоге "widgets" текущей темы, подробнее https://github.com/yupe/yupe/issues/26
 *
 * @package yupe.core.widgets
 * @abstract
 * @author yupe team
 * @link http://yupe.ru
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

    public function init()
    {
        parent::init();

        if (!$this->cacheTime && $this->cacheTime !== 0)
            $this->cacheTime = Yii::app()->getModule('yupe')->coreCacheTime;
    }

    public function getViewPath($checkTheme = false)
    {
        if (!is_object(Yii::app()->theme))
            return parent::getViewPath();

        $themeView = Yii::app()->themeManager->basePath . DIRECTORY_SEPARATOR . Yii::app()->theme->name . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . get_class($this);

        return file_exists($themeView) ? $themeView : parent::getViewPath($checkTheme = false);
    }
}