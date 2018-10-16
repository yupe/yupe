<?php
/**
 * EditableStatusColumn
 *
 * @category Widgets
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/

namespace yupe\widgets;

use Yii;
use CHtml;

Yii::import('bootstrap.widgets.TbEditableColumn');

class EditableStatusColumn extends \TbEditableColumn
{
    /**
     * @var string
     * @see TbEditable::$url
     */
    public $url;

    /**
     * Настройка отображения элементов. <br/>
     * Формат: array(значение_атрибута => array(параметр => значение)). <br/>
     * Поддерживаемые параметры: class, color. <br/>
     * Пример: <br/>
     * <pre>
     * array(
     *  Page::STATUS_DRAFT      => array('color' => '#000'),
     *  Page::STATUS_PUBLISHED  => array('color' => '#f00'),
     *  Page::STATUS_MODERATION => array('class' => 'label-danger'),
     * )
     * </pre>
     * @var array
     */
    public $options = [];

    /**
     * Список статусов в формате array(значение_атрибута => заголовок_статуса, ...)
     * @var array
     */
    public $source = [];

    public function init()
    {
        $this->editable['options']['display'] = 'js:function(value, sourceData) {
            if (typeof sourceData === "undefined") {
                return false;
            }
            var selected = $.grep(sourceData, function(o){ return value == o.value; })[0],
            itemsOptions = ' . json_encode($this->options) . ';
            var item = itemsOptions[value];
            var itemColor = "", itemClass = "";
            var html = selected.text;
            if(item){
                itemColor = item["color"] ? "style=\'background-color: " + item["color"] + "\'" : "";
                itemClass = "class=\'label " + (item["class"] ? item["class"]  : "") + "\'";
                html = "<div " + itemClass + " " + itemColor + "><span style=\'border-bottom: 1px dashed;\'>" + selected.text + "</span></div>"
            }
            $(this).html(html);
        }';

        $this->editable = array_merge(
            $this->editable,
            [
                'url'    => $this->url,
                'type'   => 'select',
                'mode'   => 'inline',
                'params' => [
                    Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
                ],
                'source' => $this->source,
            ]
        );

        // если filter принудительно не поставили в false и он пустой, то берем данные для него из source
        if ($this->filter !== false && is_null($this->filter)) {
            $this->filter = $this->source;
        }

        if (is_array($this->filter) && $this->grid->filter) {
            $this->filter = CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, ['id' => false, 'prompt' => '', 'class' => 'form-control']);
        }

        parent::init();
    }
}
