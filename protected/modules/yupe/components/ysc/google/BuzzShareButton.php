<?php
/**
 *  Виджет ysc.google.BuzzShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в Google Buzz (http://www.google.com/buzz)
 *  Подробности и варианты настроек вот тут http://www.google.com/buzz/api/admin/configPostWidget
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 * @subpackage google
 * @example В коде представления <?php $this->widget('application.components.ysc.google.BuzzShareButton');?>
 *
 */

Yii::import('zii.widgets.CPortlet');

class BuzzShareButton extends YscPortlet
{
    public $locale = 'ru';
    public $type = 'small-count';
    public $url;
    public $imageUrl;
    public $title;
    private $validTypes = array('small-count', 'normal-button', 'link', 'normal-count', 'small-button');

    public function init()
    {
        $this->title = $this->title
            ? Yii::t($this->translate, CHtml::encode($this->title))
            : 'Опубликовать в Живой ленте Google';
        $this->url = $this->url ? 'data-url="' . urlencode($this->url) . '"'
            : '';
        $this->imageUrl = $this->imageUrl
            ? 'data-imageurl="' . urlencode($this->imageUrl) . '"' : '';
        $this->locale = CHtml::encode($this->locale);
        parent::init();
    }

    public function renderContent()
    {
        echo "<a title='{$this->title}' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='{$this->type}' data-locale='{$this->locale}' {$this->url} {$this->imageUrl}></a>
             <script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>";
    }

    public function  renderDecoration()
    {

    }
}

?>

    