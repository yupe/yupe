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
            'adminMenuOrder' => Yii::t('DictionaryModule.dictionary', 'Порядок следования в меню'),
        );
    }

    public function getCategory()
    {
        return Yii::t('DictionaryModule.dictionary', 'Структура');
    }

    public function getName()
    {
        return Yii::t('DictionaryModule.dictionary', 'Справочники');
    }

    public function getDescription()
    {
        return Yii::t('DictionaryModule.dictionary', 'Модуль для простых справочников');
    }

    public function getAuthor()
    {
        return Yii::t('DictionaryModule.dictionary', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('DictionaryModule.dictionary', 'team@yupe.ru');
    }

    public function getIcon()
    {
        return "book";
    }

    public function getVersion()
    {
        return Yii::t('DictionaryModule.dictionary', '0.2');
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список справочников'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить справочник'), 'url' => array('/dictionary/default/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Значения')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
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