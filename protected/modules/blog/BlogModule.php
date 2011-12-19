<?php

class BlogModule extends YWebModule
{
	public function getCategory()
    {
        return Yii::t('social', 'Сервисы');
    }

    public function getName()
    {
        return Yii::t('social', 'Блоги');
    }

    public function getDescription()
    {
        return Yii::t('social', 'Модуль для построения блогового сообщества');
    }

    public function getAuthor()
    {
        return Yii::t('social', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('social', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('social', 'http://yupe.ru');
    }

    public function getAdminPageLink()
    {
        return '/blog/blog/';
    }

	public function init()
	{
		parent::init();

		$this->setImport(array(
			'blog.models.*',
			'blog.components.*',
		));
	}	
}