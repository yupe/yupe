<?php
class YupeModule extends YWebModule
{
    public $siteDescription;

    public $siteName;

    public $siteKeyWords;

    public $backendLayout = 'application.modules.yupe.views.layouts.column2';
    
    public $emptyLayout = 'application.modules.yupe.views.layouts.empty';

    public $theme;

    public $brandUrl;

    public function checkSelf()
    {
        if (!is_writable(Yii::app()->runtimePath))
        {
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Директория "{dir}" не досутпна для записи!',array('{dir}' => Yii::app()->runtimePath)));
        }

        if (!is_writable(Yii::app()->getAssetManager()->basePath))
        {
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Директория "{dir}" не досутпна для записи!',array('{dir}' => Yii::app()->getAssetManager()->basePath)));
        }

        if (defined('YII_DEBUG') && YII_DEBUG)
        {
            return array('type' => YWebModule::CHECK_ERROR, 'message' => Yii::t('yupe', 'Yii работает в режиме отладки, пожалуйста, отключите его! <br/> <a href="http://www.yiiframework.ru/doc/guide/ru/topics.performance">Подробнее про улучшение производительности Yii приложений</a>'));
        }

        return true;
    }

    public function getParamsLabels()
    {
        return array(
            'siteDescription' => Yii::t('yupe', 'Описание сайта'),
            'siteName' => Yii::t('yupe', 'Название сайта'),
            'siteKeyWords' => Yii::t('yupe', 'Ключевые слова сайта'),
            'backendLayout' => Yii::t('yupe', 'Layout административной части'),
            'theme' => Yii::t('yupe', 'Тема')
        );
    }

    public function getEditableParams()
    {
        return array('theme', 'backendLayout', 'siteName', 'siteDescription', 'siteKeyWords');
    }

    public function getAdminPageLink()
    {
        return '/yupe/backend/modulesettings/module/yupe';
    }

    public function getIsShowInAdminMenu()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('yupe', 'Ядрышко');
    }

    public function getName()
    {
        return Yii::t('yupe', 'Основные параметры');
    }

    public function getDescription()
    {
        return Yii::t('yupe', 'Без этого модуля ничего не работает =)');
    }

    public function getAuthor()
    {
        return Yii::t('yupe', 'xoma');
    }

    public function getAuthorEmail()
    {
        return Yii::t('yupe', 'aopeykin@yandex.ru');
    }

    public function getUrl()
    {
        return Yii::t('yupe', 'http://yupe.ru');
    }


    public function init()
    {
        parent::init();

        $this->setImport(array(
                              'yupe.models.*',
                              'yupe.components.*',
                         ));
    }
}