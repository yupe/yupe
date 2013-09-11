<?php
class ContentBlockModule extends YWebModule
{
    public function getCategory()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Content');
    }

    public function getName()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Content blocks');
    }

    public function getDescription()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Module for create simple content blocks');
    }

    public function getVersion()
    {
        return Yii::t('ContentBlockModule.contentblock', '0.2');
    }

    public function getAuthor()
    {
        return Yii::t('ContentBlockModule.contentblock', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ContentBlockModule.contentblock', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('ContentBlockModule.contentblock', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "th-large";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'contentblock.models.*',
            'contentblock.components.*',
        ));
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('ContentBlockModule.contentblock', 'Blocks list'), 'url' => array('/contentblock/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ContentBlockModule.contentblock', 'Add block'), 'url' => array('/contentblock/default/create')),
        );
    }
}