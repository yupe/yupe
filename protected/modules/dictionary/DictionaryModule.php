<?php

class DictionaryModule extends yupe\components\WebModule
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
            'adminMenuOrder' => Yii::t('DictionaryModule.dictionary', 'Menu items order'),
        );
    }

    public function getCategory()
    {
        return Yii::t('DictionaryModule.dictionary', 'Structure');
    }

    public function getName()
    {
        return Yii::t('DictionaryModule.dictionary', 'Dictionaries');
    }

    public function getDescription()
    {
        return Yii::t('DictionaryModule.dictionary', 'Module for simple dictionary');
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
            array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries list'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create dictionary'), 'url' => array('/dictionary/default/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Items')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryData/create')),
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