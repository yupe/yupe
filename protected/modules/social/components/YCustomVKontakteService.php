<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 05.05.12
 * Time: 10:55
 * To change this template use File | Settings | File Templates.
 */
class YCustomVkontakteService extends CustomVKontakteService
{
    public function init($component, $options = array())
    {
        $module = Yii::app()->getModule('social');

        $this->client_id     = $module->vkontakteClientId;
        $this->client_secret = $module->vkontakteClientSecret;

        parent::init($component, $options);
    }
}