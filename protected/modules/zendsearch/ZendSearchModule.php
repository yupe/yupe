<?php

class ZendSearchModule extends yupe\components\WebModule
{

    public $indexFiles = 'runtime.search';
    public $searchModels;


    public function getDependencies()
    {
        return array();
    }

    public function getParamsLabels()
    {
        return array(
            'indexFiles' => Yii::t('ZendSearchModule.zendsearch', 'Index data folder.'),
        );
    }

    public function getVersion()
    {
        return Yii::t('ZendSearchModule.zendsearch', '0.2');
    }

    public function getEditableParams()
    {
        return array(
            'indexFiles',
        );
    }

    public function getIsInstallDefault()
    {
        return false;
    }

    public function getCategory()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Services');
    }

    public function getName()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Find (Zend)');
    }

    public function getDescription()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Find module in terms of Zend Lucene');
    }

    public function getAuthor()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'WebAction webstudio');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'info@webaction.su');
    }

    public function getUrl()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'http://webaction.su');
    }

    public function getIcon()
    {
        return "search";
    }

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'application.modules.zendsearch.models.*',
            'application.modules.zendsearch.components.*',
            'application.modules.zendsearch.components.widgets.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
