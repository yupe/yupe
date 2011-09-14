<?php
/**
 *  Виджет ysc.facebook.FacebookShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в FaceBook (http://www.facebook.com/)
 *  Подробности и варианты настроек вот тут http://www.facebook.com/facebook-widgets/share.php
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 * @subpackage facebook
 * @example В коде представления <?php $this->widget('application.components.ysc.facebook.FacebookShareButton');?>
 *
 */
class FacebookShareButton extends YscPortlet
{
    public $type = 'button_count';
    public $text = 'Опубликовать';
    public $url;
    private $validTypes = array('button_count', 'icon_link', 'button', 'box_count');

    public function init()
    {
        $this->text = CHtml::encode(Yii::t($this->translate, $this->text));
        if (!in_array($this->type, $this->validTypes))
        {
            $this->type = 'button_count';
        }
        $this->url = $this->url ? 'share_url="' . urlencode($this->url) . '"'
            : '';
        parent::init();
    }

    public function renderContent()
    {
        echo '<a name="fb_share" type="' . $this->type . '" ' . $this->url . ' href="http://www.facebook.com/sharer.php">' . $this->text . '</a><script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>';
    }
}

?>

    