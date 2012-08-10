<?php

class DictionaryModule extends YWebModule
{

	public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('dictionary', 'Порядок следования в меню')
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
        return '0.2';
    }

    public function getNavigation()
    {
        return array(
            Yii::t('dictionary','Справочники') => '/dictionary/default/admin',
            Yii::t('dictionary','Значения справочников') => '/dictionary/dictionaryData/admin'
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
