<?php
/**
 *  YscPortlet
 *
 *  �������� ����� ��� ���� ��������/��������� �� Yii Social Components (YSC)
 *
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @link   http://allframeworks.ru/
 * @version 0.0.1
 * @package Yii Social Components (YSC)
 *
 */
class YscPortlet extends CWidget
{
    protected $translate = 'ysc';
    private $version = '0.0.1';

    public function getVersion()
    {
        return $this->version;
    }

    public function renderContent()
    {

    }

    public function run()
    {
        $this->renderContent();
    }
}

?>