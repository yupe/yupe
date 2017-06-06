<?php
/**
 *
 * @package  yupe.modules.yupe.components.behaviors
 *
 */


namespace yupe\components\behaviors;

use CBehavior;
use CHtml;
use Yii;

/**
 * Вывод виджетов в тестке страниц или новостей
 *
 * Формат записи вызова выджетов
 * 1) с кэшированием [[GalleryWidget?id=1]]
 * 2) без кэширования [[!GalleryWidget?id=1]]
 *
 * TODO:
 * 1) Написать модуль для админ панели для редактирования разрешеных виджетов и конфигурации парсинга
 * 2) Определение включеных модулей для вывода виджетов
 * 3) Привязка к RBAC или id пользователей для которых разрешен вывод виджетов из текста
 *
 * abstract class FrontController extends Controller {
 *
 *     public function behaviors() {
 *         return [
 *             'TextWidgetsBehavior'=> [
 *                'class'=> 'yupe\components\behaviors\TextWidgetsBehavior',
 *             ],
 *         ];
 *     }
 * }
 *
 * $text = '<h1>Hello World</h1>
 * [[GalleryWidget?id=1]]
 * [[!GalleryWidget?id=1]]';
 *
 * echo $this->parserWidgets($text);
 *
 * /themes/page/page/page.php
 * <p><?php echo $this->parserWidgets($page->body); ?></p>
 *
 */

/**
 * Class TextWidgetsBehavior
 * @package yupe\components\behaviors
 */
class TextWidgetsBehavior extends CBehavior
{
    /**
     * @var string Шаблон поиска виджетов в тексте
     */
    public $ruleParser = '~\[(\[)([^\[]*?)(\])\]~s';

    /**
     * @var array Массив разрешеных виджетов и путь их вызова
     */
    public $widgetActiv = [
        'GalleryWidget' => 'gallery.widgets.GalleryWidget',
        'ContentBlockWidget' => 'contentblock.widgets.ContentBlockWidget',
        'ContentBlockGroupWidget' => 'contentblock.widgets.ContentBlockGroupWidget',
    ];

    /**
     * @var integer Время кэширования
     */
    public $textWidgetsExpireTime = 3600;

    /**
     * @var string|false Заключать вывод виджета в тег
     */
    public $textWidgetsParagraph = 'div';

    /**
     * Вызов парсинга текста
     * @param $text
     * @return string
     */
    public function parserWidgets($text)
    {
        $text = $this->_processWidgets($text);
        return $text;
    }

    /**
     * Поиск виджетов по шаблону
     * @param $text
     * @return string
     */
    protected function _processWidgets($text)
    {

        $arrayFindWidget = [];

        if (preg_match_all($this->ruleParser, $text, $matches)) {

            foreach ($matches['2'] as $matche) {

                $cache = true;
                $expectedParams = [];
                $parseString = $matche;

                if (strncmp($parseString, '!', 1) === 0) {
                    $parseString = substr($parseString, 1);
                    $cache = false;
                }

                $actualInfo = parse_url(urldecode($parseString));

                if ($this->widgetActiv[$actualInfo['path']] === null) {
                    continue;
                }

                if (!empty($actualInfo['query'])) {
                    parse_str($actualInfo['query'], $expectedParams);
                }

                $arrayFindWidget['[[' . $matche . ']]'] = $this->_loadWidget($actualInfo['path'], $expectedParams, $cache);
            }
        }

        if (!empty($arrayFindWidget)) {
            $text = strtr($text, $arrayFindWidget);
        }

        return $text;

    }

    /**
     * Вызов найденых виджетов
     * @param $name
     * @param array $attributes
     * @param bool $cache
     * @return string
     */
    protected function _loadWidget($name, $attributes = [], $cache = true)
    {

        $indexCache = 'loadWidget' . $name . md5(json_encode($attributes));

        if ($cache && $cacheWidget = Yii::app()->cache->get($indexCache)) {
            return $cacheWidget;
        }

        ob_start();
        ob_implicit_flush(false);

        $widget = Yii::app()->getWidgetFactory()->createWidget($this->owner, $this->widgetActiv[$name], $attributes);
        $widget->init();
        $widget->run();
        $html = trim(ob_get_clean());

        $this->textWidgetsParagraph ? $html = CHtml::tag($this->textWidgetsParagraph, [], $html) : '';
        $cache ? Yii::app()->cache->set($indexCache, $html, $this->textWidgetsExpireTime) : '';

        return $html;
    }


}