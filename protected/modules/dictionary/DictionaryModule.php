<?php
/**
 * DictionaryModule основной класс модуля dictionary
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.dictionary
 * @since 0.1
 *
 */

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
        return Yii::t('DictionaryModule.dictionary', '0.6');
    }

    public function getAdminPageLink()
    {
        return '/dictionary/dictionaryBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries list'), 'url' => array('/dictionary/dictionaryBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create dictionary'), 'url' => array('/dictionary/dictionaryBackend/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Items')),
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryDataBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryDataBackend/create')),
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