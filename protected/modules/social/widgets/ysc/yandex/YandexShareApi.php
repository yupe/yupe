<?php
class YandexShareApi extends YscPortlet
{
    public $type;
    public $services;
    private $_validTypes = array('button', 'link');
    private $_validServices = array('yazakladki', 'myspace', 'moikrug', 'linkedin', 'juick', 'greader', 'gbuzz', 'delicious', 'evernote', 'digg', 'blogger', 'yaru', 'vkontakte', 'facebook', 'twitter', 'odnoklassniki', 'moimir', 'friendfeed', 'lj');

    public function init()
    {
        $this->type = in_array($this->type, $this->_validTypes) ? $this->type
            : 'button';

        $data = array();

        if (!$this->services || $this->services === 'all' || $this->services === '*')
        {
            $this->services = $this->_validServices;
        }

        if (is_string($this->services))
        {
            $this->services = explode(',', $this->services);
        }

        if (count($this->services))
        {
            foreach ($this->services as $service)
            {
                if (in_array($service, $this->_validServices))
                {
                    array_push($data, $service);
                }
            }
        }

        $this->services = implode(',', $this->services);

    }

    public function renderContent()
    {
        echo '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                 <div class="yashare-auto-init" data-yashareType="' . $this->type . '" data-yashareQuickServices="' . $this->services . '"></div>';
    }

}

?>