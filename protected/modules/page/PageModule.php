<?php

class PageModule extends YWebModule
{
    public $editor;

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('page', 'Порядок следования в меню')
        );
    }

    public function getCategory()
    {
        return Yii::t('page', 'Контент');
    }

    public function getName()
    {
        return Yii::t('page', 'Страницы');
    }

    public function getDescription()
    {
        return Yii::t('page', 'Модуль для создания и редактирования страничек сайта');
    }

    public function getAuthor()
    {
        return Yii::t('page', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('page', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('page', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'application.modules.page.models.*',
                              'application.modules.page.components.*',
                              'application.modules.page.components.widgets.*',
                         ));
    }
}
