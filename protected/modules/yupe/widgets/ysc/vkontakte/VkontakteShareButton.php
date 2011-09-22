<?php
/**
 *  Виджет ysc.vkontakte.VkontakteShareButton
 *
 *  Позволяет отрисовать кнопку для публикации контента в ВКонтакте (http://vkontakte.ru/)
 *  Подробности и варианты настроек вот тут http://vkontakte.ru/pages.php?act=share
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 * @subpackage vkontakte
 * @example В коде представления <?php $this->widget('application.components.ysc.vkontakte.VkontakteShareButton');?>
 *
 */
class VkontakteShareButton extends YscPortlet
{
    public $type = 'round';
    public $text = 'Сохранить';
    public $url = 'false';
    private $validTypes = array('button', 'button_nocount', 'round', 'round_nocount', 'link', 'link_noicon', 'custom');

    public function init()
    {
        if (!in_array($this->type, $this->validTypes))
        {
            $this->type = 'round';
        }
        $this->text = CHtml::encode(Yii::t($this->translate, $this->text));
        if ($this->type == 'custom')
        {
            $this->text = '<img src=\"http://vk.com/images/vk32.png?1\" />';
        }
        if ($this->url && $this->url != 'false')
        {
            $this->url = '{url:"' . urlencode($this->url) . '"}';
        }
        parent::init();
    }

    public function renderContent()
    {
        echo "<!-- Put this script tag to the <head> of your page -->
            <script type='text/javascript' src='http://vkontakte.ru/js/api/share.js?5' charset='windows-1251'></script>
            
            <!-- Put this script tag to the place, where the Share button will be -->
            <script type='text/javascript'><!--
            document.write(VK.Share.button({$this->url},{type: '{$this->type}', text: '{$this->text}'}));
            --></script>";
    }
}

?>

    