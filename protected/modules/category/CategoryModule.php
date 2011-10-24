<?php

class CategoryModule extends YWebModule
{
    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('category', 'Порядок следования в меню')
        );
    }

    public function getCategory()
    {
        return Yii::t('category', 'Контент');
    }

    public function getName()
    {
        return Yii::t('category', 'Категории/разделы');
    }

    public function getDescription()
    {
        return Yii::t('category', 'Модуль для управления категориями/разделами сайта');
    }

    public function getAuthor()
    {
        return Yii::t('category', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('category', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('category', 'http://yupe.ru');
    }


    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'category.models.*',
                              'category.components.*',
                         ));
    }
}
