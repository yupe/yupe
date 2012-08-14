<?php
class NewsModule extends YWebModule
{
    public $editor = 'application.modules.yupe.widgets.editors.imperaviRedactor.EImperaviRedactorWidget';
    public $uploadPath = 'news';
    public $mainCategory;

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath . DIRECTORY_SEPARATOR;
    }

    public function checkSelf()
    {
        $uploadPath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('news', 'Директория "{dir}" не досутпна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('news', 'Изменить настройки'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'news',
                     )),
                )),
            );
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'   => Yii::t('news', 'Главная категория новостей'),
            'adminMenuOrder' => Yii::t('news', 'Порядок следования в меню'),
            'editor'         => Yii::t('news', 'Визуальный редактор'),
            'uploadPath'     => Yii::t('news', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor' => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => Category::model()->allCategoryList,
            'uploadPath',
        );
    }

    public function getVersion()
    {
        return '0.3';
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

    public function getNavigation()
    {
        return array(
            array('icon' => 'plus-sign', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create/')),
            array('icon' => 'th-list', 'label' => Yii::t('news', 'Список новостей'), 'url' => array('/news/default/admin/')),
        );
    }

    public function getCategoryList()
    {
        $criteria = array();

        if($this->mainCategory)
            $criteria = array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            );

        return Category::model()->findAll($criteria);
    }

    public function isMultiLang()
    {
        return true;
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