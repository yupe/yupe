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

    /**
     * @since 0.8.1
     *
     * Модуль к которому относится виджет
     */
    public $module;

    /**
     * @param bool $checkTheme
     * @return null|string
     */
    public function getViewPath($checkTheme = false)
    {
        if (null === Yii::app()->getTheme()) {
            return parent::getViewPath($checkTheme);
        }

        $themeView = null;
        $reflection = new ReflectionClass(get_class($this));
        $path = explode(Yii::app()->getModulePath() . DIRECTORY_SEPARATOR, $reflection->getFileName(), 2);
        if (isset($path[1])) {
            $path = explode(DIRECTORY_SEPARATOR, $path[1], 2);
            $themeView = Yii::app()->getThemeManager()->getBasePath() . DIRECTORY_SEPARATOR .
                Yii::app()->getTheme()->getName() . DIRECTORY_SEPARATOR .
                'views' . DIRECTORY_SEPARATOR .
                $path[0] . DIRECTORY_SEPARATOR .
                'widgets' . DIRECTORY_SEPARATOR .
                $reflection->getShortName();

            if ($themeView && file_exists($themeView)) {
                return $themeView;
            }

            $themeView = implode(DIRECTORY_SEPARATOR, [Yii::app()->getModulePath(), $path[0], 'views', 'widgets', $reflection->getShortName()]);

            if ($themeView && file_exists($themeView)) {
                return $themeView;
            }
        }

        return parent::getViewPath($checkTheme);
    }

    public function init()
    {
        if(!$this->cacheTime && $this->cacheTime !== 0) {
            $this->cacheTime = (int)Yii::app()->getModule('yupe')->coreCacheTime;
        }

        parent::init();
    }

}
