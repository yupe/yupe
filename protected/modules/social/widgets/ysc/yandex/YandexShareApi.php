<?php
/**
 *  Виджет ysc.yandex.YandexShareApi
 *
 *  Выводит виджет "поделиться" от компании Яндекс.
 *  Конструктор виджета: http://api.yandex.ru/share/
 *  Документация виджета: http://api.yandex.ru/share/doc/dg/concepts/share-button-ov.xml
 *
 * @author Yupe Team
 * @link   http://yupe.ru/
 * @version 0.0.2
 * @example В коде представления <?php $this->widget('application.components.ysc.yandex.YandexShareApi'); ?>
 *
 */
class YandexShareApi extends YscPortlet
{
    /**
     *  @var string вид виджета
     */
    public $type;
    /**
     *  @var string, array, false сервисы используемые в виджете
     */
    public $services;

    private $_validTypes    = array('button', 'link', 'icon', 'none');
    private $_validServices = array(
        'yaru',         'yazakladki', 'twitter',
        'vkontakte',    'facebook',   'odnoklassniki',
        'gplus',        'blogger',    'lj',
        'linkedin',     'moikrug',    'moimir',
        'liveinternet', 'myspace',    'digg',
        'evernote',     'delicious',  'diary',
        'friendfeed',   'juick',      'tutby',
    );

    public function init()
    {
        $this->type = in_array($this->type, $this->_validTypes) ? $this->type : 'button';

        if (!$this->services)
            $this->services = $this->_validServices;
        else
        {
            if (is_string($this->services))
                $this->services = explode(',', $this->services);

            if (is_array($this->services))
            {
                foreach ($this->services as &$service)
                {
                    if (!in_array(trim($service), $this->_validServices))
                        unset($service);
                }
            }
        }
        $this->services = implode(',', $this->services);
    }

    public function renderContent()
    {
        echo '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
              <div class="yashare-auto-init" data-yashareL10n="' . Yii::app()->language . '" data-yashareType="' . $this->type . '" data-yashareQuickServices="' . $this->services . '"></div>';
    }
}