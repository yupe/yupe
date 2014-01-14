<?php
/**
 * Класс yupe\widgets\YWidget - базовый класс для всех виджетов Юпи!
 *
 * Все виджеты Юпи! должны наследовать этот класс
 * Основная особенность - view файлы для виджетов хранятся в каталоге "widgets" текущей темы, подробнее https://github.com/yupe/yupe/issues/26
 *
 * @package  yupe.modules.yupe.widgets
 * @abstract
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 */
namespace yupe\widgets;
use ReflectionClass;
use CWidget;
use Yii;

abstract class YWidget extends CWidget
{
    /**
     * cacheTime - время кэширования выборки в виджете
     * если передано 0 - выборка не кэшируется, если ничего не передано - берется время жизни кэша из ядра:
     * Yii::app()->getModule('yupe')->coreCacheTime
     *
     */
    public $cacheTime;

    /**
     *
     *  limit - кол-во записей для вывода
     *
    */

    public $limit = 5;

    /**
     *  view - название шаблона (view) который используется для отрисовки виджета
     *
     *
    */
    public $view;

    public function init()
    {
        parent::init();
    }

    public function getViewPath($checkTheme = false)
    {         
        $themeView = null;
        if (Yii::app()->theme !== null) {            
            $class = get_class($this);                                       
            $obj = new ReflectionClass($class);
            $string = explode(Yii::app()->modulePath . \DIRECTORY_SEPARATOR, $obj->getFileName(), 2);           
            if (isset($string[1])) {                
                $string = explode(\DIRECTORY_SEPARATOR, $string[1], 2);
                $themeView = Yii::app()->themeManager->basePath . '/' .
                             Yii::app()->theme->name . '/' . 'views' . '/' .
                             $string[0] . '/' . 'widgets' . '/' . $obj->getShortName();
            }            
        }
        return $themeView && file_exists($themeView) ? $themeView : parent::getViewPath($checkTheme);
    }
}