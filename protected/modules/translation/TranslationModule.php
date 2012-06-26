<?php
class TranslationModule extends YWebModule
{
    public function getCategory()
    {
        return Yii::t('translation', 'Система');
    }

    public function getName()
    {
        return Yii::t('translation', 'Перевод сообщений');
    }

    public function getDescription()
    {
        return Yii::t('translation', 'Перевод сообщений интерфейса');
    }

    public function getAdminPageLink()
    {
        return '/translation/message/admin/';
    }

	public function init()
	{
		parent::init();

		$this->setImport(array(
			'translation.models.*',
			'translation.components.*',
		));
	}
}
