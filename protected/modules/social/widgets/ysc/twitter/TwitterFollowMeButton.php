<?php
/**
 *  Виджет ysc.twitter.TwitterFollowMeButton
 *
 *  Подробности и варианты настроек вот тут http://twitter.com/goodies/buttons
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @since ysc 0.0.2
 * @package Yii Social Components (YSC)
 * @subpackage twitter
 * @example В коде представления <?php $this->widget('application.components.ysc.twitter.TwitterFollowMeButton');?>
 *
 */

class TwitterFollowMeButton extends YscPortlet
{
    const BLUE = 'a';
    const WHITE = 'b';
    const BLACK = 'c';

    public $color;

    public $type;

    public $user;

    public $alt;

    private $_validColors = array(
        'blue' => self::BLUE,
        'white' => self::WHITE,
        'black' => self::BLACK
    );

    private $_validTypes = array(
        'follow_me', 'follow_bird', 'twitter', 't_logo', 't_small', 't_mini'
    );

    public function init()
    {
        if (!$this->user)
        {
            throw new CException('Укажите учетную запись в Твиттере для виджета TwitterFollowMeButton! user => @youTwitterAccount!');
        }

        $this->color = array_key_exists(strtolower($this->color), $this->_validColors)
            ? $this->_validColors[strtolower($this->color)] : self::WHITE;

        $this->type = in_array(strtolower($this->type), $this->_validTypes)
            ? strtolower($this->type) : 'follow_me';

        parent::init();
    }

    public function renderContent()
    {
        echo '<a href="http://www.twitter.com/' . $this->user . '"><img src="http://twitter-badges.s3.amazonaws.com/' . $this->type . '-' . $this->color . '.png" alt="' . $this->alt . '"/></a>';
    }
}

?>

    
