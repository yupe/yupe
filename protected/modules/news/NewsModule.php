<?php
class NewsModule extends YWebModule
{
    public $uploadPath        = 'news';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize           = 0;
    public $maxSize           = 5368709120;
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

    public function getInstall()
    {
        if(parent::getInstall())
            @mkdir($this->getUploadPath(),0755);

        return false;
    }

    public function checkSelf()
    {
        $messages = array();

        $uploadPath = $this->getUploadPath();

        if (!is_writable($uploadPath))
            $messages[YWebModule::CHECK_ERROR][] =  array(
                'type'    => YWebModule::CHECK_ERROR,
                'message' => Yii::t('NewsModule.news', 'Директория "{dir}" не доступна для записи! {link}', array(
                    '{dir}'  => $uploadPath,
                    '{link}' => CHtml::link(Yii::t('NewsModule.news', 'Изменить настройки'), array(
                        '/yupe/backend/modulesettings/',
                        'module' => 'news',
                     )),
                )),
            );

        return (isset($messages[YWebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getParamsLabels()
    {
        return array(
            'mainCategory'      => Yii::t('NewsModule.news', 'Главная категория новостей'),
            'adminMenuOrder'    => Yii::t('NewsModule.news', 'Порядок следования в меню'),
            'editor'            => Yii::t('NewsModule.news', 'Визуальный редактор'),
            'uploadPath'        => Yii::t('NewsModule.news', 'Каталог для загрузки файлов (относительно {path})', array('{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule("yupe")->uploadPath)),
            'allowedExtensions' => Yii::t('NewsModule.news', 'Разрешенные расширения (перечислите через запятую)'),
            'minSize'           => Yii::t('NewsModule.news', 'Минимальный размер (в байтах)'),
            'maxSize'           => Yii::t('NewsModule.news', 'Максимальный размер (в байтах)'),
        );
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(),'id','name'),
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
        );
    }

    public function getVersion()
    {
        return Yii::t('NewsModule.news', '0.4');
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('NewsModule.news', 'Контент');
    }

    public function getName()
    {
        return Yii::t('NewsModule.news', 'Новости');
    }

    public function getDescription()
    {
        return Yii::t('NewsModule.news', 'Модуль для создания и публикации новостей');
    }

    public function getAuthor()
    {
        return Yii::t('NewsModule.news', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('NewsModule.news', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('NewsModule.news', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "leaf";
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Список новостей'), 'url' => array('/news/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/default/create')),
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