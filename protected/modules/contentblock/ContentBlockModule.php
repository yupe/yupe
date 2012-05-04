<?php
class ContentBlockModule extends YWebModule
{

    public function getCategory()
    {
        return Yii::t('contentblock', 'Структура');
    }

    public function getName()
    {
        return Yii::t('contentblock', 'Блоки контента');
    }

    public function getDescription()
    {
        return Yii::t('contentblock', 'Модуль для создания и редактирования произвольных блоков контента');
    }

    public function getVersion()
    {
        return Yii::t('contentblock', '0.2');
    }

    public function getAuthor()
    {
        return Yii::t('contentblock', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('contentblock', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('contentblock', 'http://yupe.ru');
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'contentblock.models.*',
            'contentblock.components.*',
        ));
    }
}