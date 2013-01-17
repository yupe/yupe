<?php
class SearchModule extends YWebModule
{
    protected $info = false;

    public function getEditableParams()
    {
        return array(
        //    'param',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'param' => Yii::t('SearchModule.search', ''),
        );
    }

    public function getCategory()
    {
        return Yii::t('SearchModule.search', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('SearchModule.search', 'Поиск');
    }

    public function getDescription()
    {
        return Yii::t('SearchModule.search', 'Функции поиска по сайту.');
    }

    public function getAuthor()
    {
        return 'Archaron';
    }

    public function getAuthorEmail()
    {
        return Yii::t('SearchModule.search', 'tsm@glavset.ru');
    }

    public function getVersion()
    {
        return Yii::t('SearchModule.search', '0.1');
    }

    public function getUrl()
    {
        return Yii::t('SearchModule.search', 'http://yupe.ru/');
    }

    public function getAdminPageLink()
    {
        return '/';
    }

    public function getIcon()
    {
        return "search";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'search.models.*',
            'search.components.*',
        ));
    }
}