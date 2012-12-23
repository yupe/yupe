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
            'param' => Yii::t('search', ''),
        );
    }

    public function getCategory()
    {
        return Yii::t('search', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('search', 'Поиск');
    }

    public function getDescription()
    {
        return Yii::t('search', 'Функции поиска по сайту.');
    }

    public function getAuthor()
    {
        return Yii::t('email', 'Archaron');
    }

    public function getAuthorEmail()
    {
        return Yii::t('search', 'tsm@glavset.ru');
    }

    public function getVersion()
    {
        return Yii::t('search', '0.1');
    }

    public function getUrl()
    {
        return Yii::t('search', 'http://yupe.ru/');
    }

    public function getAdminPageLink()
    {
        return '/';
    }

    public function getIcon()
    {
        return "search";
    }

    public function getIsInstallDefault()
    {
        return false;
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