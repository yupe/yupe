<?php
class NewsModule extends YWebModule
{
    public $uploadPath        = 'news';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize;
    public $maxFiles          = 1;
    public $mainCategory;

    public function getDependencies()
    {
        return array(
            'user',
            'category',
        );
    }

    public function getUploadPath()
    {
        return Yii::getPathOfAlias('webroot') . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' . $this->uploadPath . '/';
    }

    public function checkSelf()
    {
        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            return array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('news', 'Директория "{dir}" не доступна для записи! {link}', array(
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
            'mainCategory'      => Yii::t('news', 'Главная категория новостей'),
            'adminMenuOrder'    => Yii::t('news', 'Порядок следования в меню'),
            'editor'            => Yii::t('news', 'Визуальный редактор'),
            'uploadPath'        => Yii::t('news', 'Каталог для загрузки файлов (относительно Yii::app()->getModule("yupe")->uploadPath)'),
            'allowedExtensions' => Yii::t('news', 'Разрешенные расширения (перечислите через запятую)'),
            'minSize'           => Yii::t('news', 'Минимальный размер (в байтах)'),
            'maxSize'           => Yii::t('news', 'Максимальный размер (в байтах)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => Category::model()->allCategoryList,
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
        );
    }

    public function getVersion()
    {
        return Yii::t('page', '0.3');
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
            array('icon' => 'list-alt', 'label' => Yii::t('news', 'Список новостей'), 'url' => array('/news/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
        );
    }

    public function getCategoryList()
    {
        $criteria = ($this->mainCategory)
            ? array(
                'condition' => 'id = :id OR parent_id = :id',
                'params'    => array(':id' => $this->mainCategory),
                'order'     => 'id ASC',
            )
            : array();

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