<?php

class ContentBlockModule extends YWebModule
{

    public function getCategory()
    {
        return Yii::t('contentblock', 'Контент');
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
        return Yii::t('contentblock', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('contentblock', 'aopeykin@yandex.ru');
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
