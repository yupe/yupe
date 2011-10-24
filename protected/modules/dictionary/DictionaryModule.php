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
        return Yii::t('dictionary', 'Контент');
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
        return Yii::t('dictionary', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('dictionary', 'aopeykin@yandex.ru');
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
