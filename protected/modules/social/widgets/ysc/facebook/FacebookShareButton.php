<?php
/**
 * File Doc Comment
 *  Виджет ysc.facebook.FacebookShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в FaceBook (http://www.facebook.com/)
 *  Подробности и варианты настроек вот тут http://www.facebook.com/facebook-widgets/share.php
 *
 * @category   YupeWidgets
 * @package    YupeCMS
 * @subpackage Facebook
 * @author     Opeykin A. <aopeykin@yandex.ru>
 * @license    BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version    0.0.2
 * @link       http://allframeworks.ru/
 * @example    В коде представления <?php $this->widget('application.modules.social.widgets.ysc.facebook.FacebookShareButton');?>
 *
 */

/**
 *  Виджет ysc.facebook.FacebookShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в FaceBook (http://www.facebook.com/)
 *  Подробности и варианты настроек вот тут http://www.facebook.com/facebook-widgets/share.php
 *
 * @category   YupeWidgets
 * @package    YupeCMS
 * @subpackage Facebook
 * @author     Opeykin A. <aopeykin@yandex.ru>
 * @license    BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version    0.0.2
 * @link       http://allframeworks.ru/
 * @example    В коде представления <?php $this->widget('application.modules.social.widgets.ysc.facebook.FacebookShareButton');?>
 *
 */
class FacebookShareButton extends YscPortlet
{
    public $type        = 'button_count';
    public $text        = 'Опубликовать';
    public $url;
    /**
     * Название приватных переменных
     * должно начинаться с подчёркивания.
     **/
    private $_validTypes = array('button_count', 'icon_link', 'button', 'box_count');

    /**
     * Инициализация виджета:
     *
     * @return nothing
     **/
    public function init()
    {
        $this->text = CHtml::encode(Yii::t($this->translate, $this->text));
        $this->url  = $this->url ? 'share_url="' . urlencode($this->url) . '"' : '';
        if (!in_array($this->type, $this->_validTypes))
            $this->type = 'button_count';
        parent::init();
    }

    /**
     * Отрисовка виджета:
     *
     * @return nothing
     **/
    public function renderContent()
    {
        echo <<<EOF
        <a name="fb_share" type="{$this->type}" {$this->url} href="http://www.facebook.com/sharer.php">
            {$this->text}
        </a>
        <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
EOF;
    }
}
