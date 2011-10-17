<?php
/**
 *  Виджет ysc.twitter.TweetMeMeShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в twitter используя, сервис http://help.tweetmeme.com/2009/04/06/tweetmeme-button/
 *  Подробности и варианты настроек вот тут http://help.tweetmeme.com/2009/04/06/tweetmeme-button/
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 * @subpackage twitter
 * @example В коде представления <?php $this->widget('application.components.ysc.twitter.TweetMeMeShareButton');?>
 *
 */
class TweetMeMeShareButton extends YscPortlet
{
    public $url;
    public $style = 'normal';
    public $source = '';
    public $service = '';
    public $api;

    private $validStyles = array('normal', 'compact');

    public function init()
    {
        if (!in_array($this->style, $this->validStyles))
        {
            $this->style = 'normal';
        }
        $this->style = 'tweetmeme_style = "' . CHtml::encode($this->style) . '";';
        $this->url = $this->url
            ? 'tweetmeme_url = ' . urlencode($this->url) . ';' : '';
        $this->source = 'tweetmeme_source = "' . CHtml::encode($this->source) . '";';
        $this->service = 'tweetmeme_source = "' . CHtml::encode($this->service) . '";';
        $this->api = 'tweetmeme_source = "' . CHtml::encode($this->api) . '";';
        parent::init();
    }

    public function renderContent()
    {
        echo '<script type="text/javascript">' . $this->style . $this->url . $this->source . $this->service . $this->api . '</script>';
        echo '<script type="text/javascript" src="http://tweetmeme.com/i/scripts/button.js"></script>';
    }
}

?>

    