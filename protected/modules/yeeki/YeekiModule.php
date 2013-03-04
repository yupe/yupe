<?php
/**
 * Yeeki module.
 *
 * Includes all necessary wiki functionality. Can be used as a module in your
 * application.
 */
class YeekiModule extends YWebModule
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
            'adminMenuOrder' => Yii::t('Yeeki.yeeki', 'Порядок следования в меню'),
            'editor'         => Yii::t('Yeeki.yeeki', 'Визуальный редактор'),
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
        return Yii::t('Yeeki.yeeki', 'Контент');
    }

    public function getAdminPageLink()
    {
        return '/wiki/default/index';
    }

    public function getName()
    {
        return Yii::t('Yeeki.yeeki', 'Wiki');
    }

    public function getDescription()
    {
        return Yii::t('Yeeki.yeeki', 'Модуль для создания раздела wiki');
    }

    public function getVersion()
    {
        return Yii::t('Yeeki.yeeki', '0.1');
    }

    public function getAuthor()
    {
        return Yii::t('Yeeki.yeeki', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('Yeeki.yeeki', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('Yeeki.yeeki', 'http://yupe.ru');
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