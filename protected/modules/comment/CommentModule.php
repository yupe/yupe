<?php

class CommentModule extends YWebModule
{
	public $defaultCommentStatus = Comment::STATUS_APPROVED;
	
	public function getCategory()
	{
		return Yii::t('comment','Контент');
	}	
	
	public function getName()
	{
		$count = Comment::model()->new()->count();		
		return $count ? Yii::t('comment','Комментарии')." ($count)"  :Yii::t('comment','Комментарии');
	}
	
	public function getDescription()
	{
		return Yii::t('comment','Модуль для простых комментариев');
	}	
	
	public function getVersion()
	{
		return Yii::t('comment','0.2');
	}
	
	public function getAuthor()
	{
		return Yii::t('comment','Опейкин Андрей');
	}
	
	public function getAuthorEmail()
	{
		return Yii::t('comment','aopeykin@yandex.ru');
	}
	
	public function getUrl()
	{
		return Yii::t('comment','http://yupe.ru');
	}
	
	
	public function init()
	{
		parent::init();
		
		$this->setImport(array(
			'comment.models.*',			
		));
	}	
}
