<?php

/**
 * ContentBlockModule основной класс модуля contentblock
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.contentblock
 * @since 0.1
 *
 */

class ContentBlockModule extends yupe\components\WebModule
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
        return Yii::t('ContentBlockModule.contentblock', '0.6');
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
        ));
    }

    public function getAdminPageLink()
    {
        return '/contentblock/contentBlockBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('ContentBlockModule.contentblock', 'Blocks list'), 'url' => array('/contentblock/contentBlockBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('ContentBlockModule.contentblock', 'Add block'), 'url' => array('/contentblock/contentBlockBackend/create')),
        );
    }
}