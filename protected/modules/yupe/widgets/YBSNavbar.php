<?php

/**
 * YBSNavbar файл класса.
 *
 * @author Alexander Tischenko <tsm@glavset.ru>
 * @link http://yupe.ru
 * @copyright Copyright &copy; 2012 Yupe!
 * @license BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 */
/**
 * YBSNavbar отображает навигационную панельку
 *
 * Виджет, основанный на zii::CMenu, использует bootstrap.
 *
 * Пример использования для построения меню модулей
 * <pre>
 *    $this->widget('YBSNavbar', array(
 *      'hideEmptyItems' => true,
 *      'items' => Yii::app()->getModule('yupe')->getModules(true),
 *      'fixed'=> 'top',
 *      'brand' => "Yupe!"
 *     )); ?>
 * </pre>
 *
 *
 * @author Alexander Tischenko <tsm@glavset.ru>
 * @package yupe.core
 * @since 0.0.4 
 */
Yii::import('zii.widgets.CMenu');

class YBSNavbar extends CMenu
{

    /**
     * @var string Фиксировать панель сверху или снизу экрана
     * Возможны значения:
     * <ul>
     * <li><b>top</b> - фиксировать панель сверху экрана. Убедитесь что вы оставили запас около 40px сверху.</li>
     * <li><b>bottom</b> - фиксировать панель снизу экрана.</li>
     * </ul>
     * В случае, если параметр {@link fixed} не указан, панель не фиксируется, а вставляется в текущую позицию.
     *
     */
    public $fixed = "";

    /**
     * @var mixed Ссылка на "бренд"
     * Задает текст рядом с меню, например на главную страницу.
     * Формат такой же, что и у параметра url в CHtml::link()
     */
    public $brand = "";

    /**
     * @var boolean Использовать проценты вместо фиксированной сетки
     * <ul>
     * <li><b>true</b> - использовать плавающий контейнер, основанный на процентах.</li>
     * <li><b>false</b> - использовать фиксированный контейнер в 940px</li>
     * </ul>
     */
    public $fluid = true;

    public function init()
    {
        parent::init();
        if ($this->fixed && !in_array($this->fixed, array("top", "bottom")))
            throw new CException("'fixed' parameter accepts only 'top' or 'bottom'");

        if ($this->brand && is_string($this->brand))
            $this->brand = array($this->brand, "#");
    }

    protected function renderMenu($items)
    {
        if (count($items))
        {
            echo CHtml::openTag("div", array("class" => "navbar" . ($this->fixed ? (" navbar-fixed-" . $this->fixed) : "")));
            echo CHtml::openTag("div", array("class" => "navbar-inner"));
            echo CHtml::openTag("div", array("class" => "container" . ($this->fluid ? "-fluid" : "")));

            // Show brand link, if specified
            if (is_array($this->brand))
                echo CHtml::link($this->brand[0], $this->brand[1], array("class" => "brand"));

            echo CHtml::openTag('ul', array("class" => "nav")) . "\n";
            $this->renderMenuRecursive($items);
            echo CHtml::closeTag('ul');
            echo CHtml::closeTag("div");
            echo CHtml::closeTag("div");
            echo CHtml::closeTag("div");
        }
    }

    protected function renderMenuRecursive($items)
    {
        $count = 0;
        $n = count($items);
        foreach ($items as $item)
        {
            $count++;
            $options = isset($item['itemOptions']) ? $item['itemOptions'] : array();
            $class = array();
            if ($item['active'] && $this->activeCssClass != '')
                $class[] = $this->activeCssClass;
            if ($count === 1 && $this->firstItemCssClass != '')
                $class[] = $this->firstItemCssClass;
            if ($count === $n && $this->lastItemCssClass != '')
                $class[] = $this->lastItemCssClass;
            if ($class !== array())
            {
                if (empty($options['class']))
                    $options['class'] = implode(' ', $class);
                else
                    $options['class'].=' ' . implode(' ', $class);
            }

            $hasChilds = isset($item['items']) && count($item['items']);

            echo CHtml::openTag('li', $hasChilds ? array("class" => "dropdown") : array());
            echo $this->renderMenuItem($item);

            if ($hasChilds)
            {
                echo "\n" . CHtml::openTag('ul', array("class" => "dropdown-menu")) . "\n";
                $this->renderMenuRecursive($item['items']);
                echo CHtml::closeTag('ul') . "\n";
            }

            echo CHtml::closeTag('li') . "\n";
        }
    }

    protected function renderMenuItem($item)
    {
        if (isset($item['url']))
        {
            $label = $this->linkLabelWrapper === null ? $item['label'] : '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';
            if (isset($item['items']) && count($item['items']))
                return CHtml::link($label . '<b class="caret"></b>', $item['url'], array("class" => "dropdown-toggle", "data-toggle" => "dropdown"));
            else
                return CHtml::link($label, $item['url']);
        }
        else
            return CHtml::tag('span', isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
    }
}