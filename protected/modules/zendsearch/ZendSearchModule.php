<?php

/**
 * ZendSearchModule основной класс модуля zendsearch
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package yupe.modules.zendsearch
 * @since 0.1
 *
 */
class ZendSearchModule extends yupe\components\WebModule
{
    /**
     *
     */
    const VERSION = '1.0';

    /**
     * @var string
     */
    public $indexFiles = 'runtime.search';

    /**
     * @var
     */
    public $searchModels;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [];
    }

    /**
     * массив групп параметров модуля, для группировки параметров на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '1.main' => [
                'label' => Yii::t('YupeModule.yupe', 'Main settings'),
                'items' => [
                    'indexFiles',
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'indexFiles' => Yii::t('ZendSearchModule.zendsearch', 'Index data folder.'),
        ];
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'indexFiles',
        ];
    }

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Services');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Search');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'Find module in terms of Zend Lucene');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'support@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('ZendSearchModule.zendsearch', 'https://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-search';
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/zendsearch/manageBackend/index';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.zendsearch.models.*',
                'application.modules.zendsearch.components.*',
                'application.modules.zendsearch.components.widgets.*',
            ]
        );
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('ZendSearchModule.zendsearch', 'Index'),
                'url' => ['/zendsearch/manageBackend/index'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'ZendSearch.ZendSearchManager',
                'description' => Yii::t('ZendSearchModule.zendsearch', 'Manage search index'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Zendsearch.ManageBackend.Index',
                        'description' => Yii::t('ZendSearchModule.zendsearch', 'Reindex site'),
                    ],
                ],
            ],
        ];
    }
}
