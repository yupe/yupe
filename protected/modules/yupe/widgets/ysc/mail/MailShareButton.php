<?php
/**
 *  Виджет ysc.mail.MailShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в Моем Мире (http://mail.ru)
 *  Подробности и варианты настроек вот тут http://developers.my.mail.ru/wiki/Ссылки@Mail.Ru
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 * @subpackage mail
 * @example В коде представления <?php $this->widget('application.components.ysc.mail.MailShareButton',array('type' => 'big','url' => 'http://mysite.ru/some-link/','text' => 'Расшарить на mail.ru!'));?>
 *
 */
class MailShareButton extends YscPortlet
{
    public $type = 'button_count';
    public $text = 'В Мой Мир';
    public $url = null;
    private $validTypes = array('button_count', 'button', 'big', 'micro');

    public function init()
    {
        if (!in_array($this->type, $this->validTypes))
        {
            $this->type = 'button_count';
        }
        $this->text = CHtml::encode(Yii::t($this->translate, $this->text));
        $this->url = $this->url ? "?share_url=" . urlencode($this->url) . ""
            : '';
        parent::init();
    }

    public function renderContent()
    {
        echo "<a class='mrc__share' type='{$this->type}' href='http://connect.mail.ru/share{$this->url}'>{$this->text}</a><script src='http://cdn.connect.mail.ru/js/share/2/share.js' type='text/javascript'></script>";
    }
}

?>

    