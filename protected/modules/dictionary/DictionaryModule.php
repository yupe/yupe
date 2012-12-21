<?php

class DictionaryModule extends YWebModule
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
            'adminMenuOrder' => Yii::t('dictionary', 'Порядок следования в меню'),
        );
    }

    public function getCategory()
    {
        return Yii::t('dictionary', 'Структура');
    }

    public function getName()
    {
        return Yii::t('dictionary', 'Справочники');
    }

    public function getDescription()
    {
        return Yii::t('dictionary', 'Модуль для простых справочников');
    }

    public function getAuthor()
    {
        return Yii::t('dictionary', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('dictionary', 'team@yupe.ru');
    }

    public function getIcon()
    {
        return "book";
    }

    public function getVersion()
    {
        return Yii::t('dictionary', '0.2');
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('dictionary', 'Справочники')),
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список справочников'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
            array('label' => Yii::t('dictionary', 'Значения')),
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
        );
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'dictionary.models.*',
            'dictionary.components.*',
        ));
    }
}