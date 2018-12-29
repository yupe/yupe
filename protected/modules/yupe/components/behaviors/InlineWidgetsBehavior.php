<?php
/**
 * InlineWidgetsBehavior allows render widgets in page content
 *
 * Config:
 * <code>
 * return array(
 *     // ...
 *     'params'=>array(
 *          // ...
 *         'runtimeWidgets'=>array(
 *             'Share',
 *             'Comments',
 *             'blog.widgets.LastPosts',
 *         }
 *     }
 * }
 * </code>
 *
 * Widget:
 * <code>
 * class LastPostsWidget extends CWidget
 * {
 *     public $tpl='default';
 *     public $limit=3;
 *
 *     public function run()
 *     {
 *         $posts = Post::model()->published()->last($this->limit)->findAll();
 *         $this->render('LastPosts/' . $this->tpl,array(
 *             'posts'=>$posts,
 *         ));
 *     }
 * }
 * </code>
 *
 * Controller:
 * <code>
 * class Controller extends CController
 * {
 *     public function behaviors()
 *     {
 *         return array(
 *             'InlineWidgetsBehavior'=>array(
 *                 'class'=>'DInlineWidgetsBehavior',
 *                 'location'=>'application.components.widgets',
 *                 'widgets'=>Yii::app()->params['runtimeWidgets'],
 *              ),
 *         );
 *     }
 * }
 * </code>
 *
 * For rendering widgets in View you must call Controller::decodeWidgets() method:
 * <code>
 * $text = '
 *     <h2>Lorem ipsum</h2>
 *     <p>[*LastPosts*]</p>
 *     <p>[*LastPosts|limit=4*]</p>
 *     <p>[*LastPosts|limit=5;tpl=small*]</p>
 *     <p>[*LastPosts|limit=5;tpl=small|cache=300*]</p>
 *     <p>Dolor...</p>
 * ';
 * echo $this->decodeWidgets($text);
 * </code>
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.2
 */

class InlineWidgetsBehavior extends CBehavior
{
    /**
     * @var string marker of block begin
     */
    public $startBlock = '{{w:';
    /**
     * @var string marker of block end
     */
    public $endBlock = '}}';
    /**
     * @var string alias if needle using default location 'path.to.widgets'
     */
    public $location = 'core.widgets';
    /**
     * @var string global classname suffix like 'Widget'
     */
    public $classSuffix = '';
    /**
     * @var array of allowed widgets
     */
    public $widgets = array();

    protected $_widgetToken;

    public function __construct()
    {
        $this->_initToken();
    }

    /**
     * Content parser
     * Use $this->decodeWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function decodeWidgets($text)
    {
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_replaceBlocks($text);
        $text = $this->_processWidgets($text);
        return $text;
    }

    /**
     * Content cleaner
     * Use $this->clearWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function clearWidgets($text)
    {
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_replaceBlocks($text);
        $text = $this->_clearWidgets($text);
        return $text;
    }

    protected function _processWidgets($text)
    {
        if (preg_match('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', $text)) {
            foreach ($this->widgets as $alias) {
                $widget = $this->_getClassByAlias($alias);

                while (preg_match('#\{' . $this->_widgetToken . ':' . $widget . '(\|([^}]*)?)?' . $this->_widgetToken . '\}#is', $text, $p)) {
                    $text = str_replace($p[0], $this->_loadWidget($alias, isset($p[2]) ? $p[2] : ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    protected function _clearWidgets($text)
    {
        return preg_replace('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', '', $text);
    }

    protected function _initToken()
    {
        $this->_widgetToken = md5(microtime());
    }

    protected function _replaceBlocks($text)
    {
        $text = str_replace($this->startBlock, '{' . $this->_widgetToken . ':', $text);
        $text = str_replace($this->endBlock, $this->_widgetToken . '}', $text);
        return $text;
    }

    protected function _clearAutoParagraphs($output)
    {
        $output = str_replace('<p>' . $this->startBlock, $this->startBlock, $output);
        $output = str_replace($this->endBlock . '</p>', $this->endBlock, $output);
        return $output;
    }

    protected function _loadWidget($name, $attributes = '')
    {
        $attrs = $this->_parseAttributes($attributes);
        $cache = $this->_extractCacheExpireTime($attrs);

        $index = 'widget_' . $name . '_' . serialize($attrs);

        if ($cache && $cachedHtml = Yii::app()->cache->get($index)) {
            $html = $cachedHtml;
        } else {
            ob_start();
            $widgetClass = $this->_getFullClassName($name);
            $widget = Yii::app()->getWidgetFactory()->createWidget($this->owner, $widgetClass, $attrs);
            $widget->init();
            $widget->run();
            $html = trim(ob_get_clean());
            Yii::app()->cache->set($index, $html, $cache);
        }

        return $html;
    }

    protected function _parseAttributes($attributesString)
    {
        $params = explode(';', $attributesString);
        $attrs = array();

        foreach ($params as $param) {
            if ($param) {
                list($attribute, $value) = explode('=', $param);
                if ($value) $attrs[$attribute] = trim($value);
            }
        }

        ksort($attrs);
        return $attrs;
    }

    protected function _extractCacheExpireTime(&$attrs)
    {
        $cache = 0;
        if (isset($attrs['cache'])) {
            $cache = (int)$attrs['cache'];
            unset($attrs['cache']);
        }
        return $cache;
    }

    protected function _getFullClassName($name)
    {
        $widgetClass = $name . $this->classSuffix;
        if ($this->_getClassByAlias($widgetClass) == $widgetClass && $this->location)
            $widgetClass = $this->location . '.' . $widgetClass;
        return $widgetClass;
    }

    protected function _getClassByAlias($alias)
    {
        $paths = explode('.', $alias);
        return array_pop($paths);
    }
}
