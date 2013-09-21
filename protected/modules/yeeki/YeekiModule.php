<?php
/**
 * Yeeki module.
 *
 * Includes all necessary wiki functionality. Can be used as a module in your
 * application.
 */
class YeekiModule extends yupe\components\WebModule
{

    public function getDependencies()
    {
        return array(
            'user',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('YeekiModule.yeeki', 'Menu items order'),
            'editor'         => Yii::t('YeekiModule.yeeki', 'Visual Editor'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->editors,
        );
    }

    public function getCategory()
    {
        return Yii::t('YeekiModule.yeeki', 'Content');
    }

    public function getAdminPageLink()
    {
        return '/wiki/default/index';
    }

    public function getName()
    {
        return Yii::t('YeekiModule.yeeki', 'Wiki');
    }

    public function getDescription()
    {
        return Yii::t('YeekiModule.yeeki', 'Module for create and manage wiki pages');
    }

    public function getVersion()
    {
        return Yii::t('YeekiModule.yeeki', '0.1');
    }

    public function getAuthor()
    {
        return Yii::t('YeekiModule.yeeki', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('YeekiModule.yeeki', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('YeekiModule.yeeki', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "file";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'yeeki.components.*',
            'application.modules.yeeki.modules.wiki.WikiModule',
            'application.modules.yeeki.modules.wiki.controllers.*',
            'application.modules.yeeki.modules.wiki.models.*',
            'application.modules.yeeki.modules.wiki.*',
            'application.modules.yeeki.modules.wiki.components.*',
        ));

        if (!$this->editor)
            $this->editor = Yii::app()->getModule('yupe')->editor;
    }
}