<?php
class NewsModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';

    public $uploadPath = 'news';

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath.DIRECTORY_SEPARATOR;
    }

    public function checkSelf()
    {
        $uploadPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('news', 'Директория "{dir}" не досутпна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('news', 'Изменить настройки'), array( '/yupe/backend/modulesettings/', 'module' => 'news' ))
                )),
            );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('news','Порядок следования в меню'),
            'editor'         => Yii::t('news','Визуальный редактор'),
            'uploadPath'     => Yii::t('news', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'uploadPath'
        );
    }

    public  function getVersion()
    {
        return '0.2';
    }

    public function getCategory()
    {
        return Yii::t('news', 'Контент');
    }

    public function getName()
    {
        return Yii::t('news', 'Новости');
    }

    public function getDescription()
    {
        return Yii::t('news', 'Модуль для создания и публикации новостей');
    }

    public function getAuthor()
    {
        return Yii::t('news', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('news', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('news', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "leaf";
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'news.models.*',
                              'news.components.*',
                         ));
    }
}