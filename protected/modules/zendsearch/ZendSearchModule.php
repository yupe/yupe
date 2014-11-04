<?php

/**
 * ZendSearchModule основной класс модуля zendsearch
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.zendsearch
 * @since 0.1
 *
 */
class ZendSearchModule extends yupe\components\WebModule
{
    const VERSION = '0.9';

    public $indexFiles = 'runtime.search';

    public $searchModels;

    public function getDependencies()
    {
        return array();
    }

    /**
     * массив групп параметров модуля, для группировки параметров на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('YupeModule.yupe', 'Main settings'),
            ),
        );
    }

    public function getParamsLabels()
    {
        return array(
            'indexFiles' => Yii::t('ZendSearchModule.zendsearch', 'Index data folder.'),
        );
    }

    public function getVersion()
    {
        return self::VERSION;
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
        return Yii::t('ZendSearchModule.zendsearch', 'Search');
    }

    public function getDescription()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Find module in terms of Zend Lucene');
    }

    public function getAuthor()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'amylabs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'hello@amylabs.ru');
    }

    public function getUrl()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'http://amylabs.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-search";
    }

    public function getAdminPageLink()
    {
        return '/zendsearch/manageBackend/index';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'application.modules.zendsearch.models.*',
                'application.modules.zendsearch.components.*',
                'application.modules.zendsearch.components.widgets.*',
            )
        );
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('ZendSearchModule.zendsearch', 'Index'),
                'url'   => array('/zendsearch/manageBackend/index')
            )
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'ZendSearch.ZendSearchManager',
                'description' => Yii::t('ZendSearchModule.zendsearch', 'Manage search index'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Zendsearch.ManageBackend.Create',
                        'description' => Yii::t('ZendSearchModule.zendsearch', 'Reindex site')
                    ),
                )
            )
        );
    }
}
