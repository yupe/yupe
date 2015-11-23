<?php

/**
 * ContentBlockModule основной класс модуля contentblock
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.contentblock
 * @since 0.1
 *
 */
class ContentBlockModule extends yupe\components\WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'category',
        ];
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Content');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Blocks');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Module for create simple content blocks');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('ContentBlockModule.contentblock', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('ContentBlockModule.contentblock', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('ContentBlockModule.contentblock', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return "fa fa-fw fa-th-large";
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'contentblock.models.*',
            ]
        );
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/contentblock/contentBlockBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('ContentBlockModule.contentblock', 'Blocks list'),
                'url' => ['/contentblock/contentBlockBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('ContentBlockModule.contentblock', 'Add block'),
                'url' => ['/contentblock/contentBlockBackend/create'],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'ContentBlock.ContentBlockManager',
                'description' => Yii::t('ContentBlockModule.contentblock', 'Manage blocks'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'ContentBlock.ContentblockBackend.Create',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Creating block'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'ContentBlock.ContentblockBackend.Delete',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Removing block'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'ContentBlock.ContentblockBackend.Index',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'List of blocks'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'ContentBlock.ContentblockBackend.Update',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Editing blocks'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'ContentBlock.ContentblockBackend.View',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Viewing blocks'),
                    ],
                ],
            ],
        ];
    }
}
