<?php
/**
 *  Виджет ysc.twitter.TweeterShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в twitter используя, сервис http://help.tweetmeme.com/2009/04/06/tweetmeme-button/
 *  Подробности и варианты настроек вот тут http://twitter.com/goodies/tweetbutton
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @since ysc 0.0.2
 * @package Yii Social Components (YSC)
 * @subpackage twitter
 * @example В коде представления <?php $this->widget('application.components.ysc.twitter.TweeterShareButton');?>
 *
 */

class TwitterShareButton extends YscPortlet
{
    public $type;

    public $via;

    public $related;

    public $relatedDescription;

    public $text;

    public $url;

    public $lang;

    private $_validTypes = array('none', 'vertical', 'horizontal');

    private $_validLangs = array('fr', 'de', 'en', 'es', 'ja');

    public function init()
    {
        $this->type = in_array(strtolower($this->type), $this->_validTypes)
            ? $this->type : 'horizontal';

        $this->lang = in_array(strtolower($this->lang), $this->_validTypes)
            ? $this->lang : 'en';

        parent::init();
    }

    public function renderContent()
    {
        echo '<a href="http://twitter.com/share" class="twitter-share-button" data-url="' . $this->url . '" data-text="' . $this->text . '" data-count="' . $this->type . '" data-via="' . $this->via . '" data-related="' . $this->related . '" data-lang="' . $this->lang . '">Twitter</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
    }
}

?>

    
