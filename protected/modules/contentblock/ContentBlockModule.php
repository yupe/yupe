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
    const VERSION = '0.9';

    public function getDependencies()
    {
        return array(
            'category',
        );
    }

    public function getCategory()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Content');
    }

    public function getName()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Blocks');
    }

    public function getDescription()
    {
        return Yii::t('ContentBlockModule.contentblock', 'Module for create simple content blocks');
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAuthor()
    {
        return Yii::t('ContentBlockModule.contentblock', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('ContentBlockModule.contentblock', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('ContentBlockModule.contentblock', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-th-large";
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'contentblock.models.*',
            )
        );
    }

    public function getAdminPageLink()
    {
        return '/contentblock/contentBlockBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('ContentBlockModule.contentblock', 'Blocks list'),
                'url'   => array('/contentblock/contentBlockBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('ContentBlockModule.contentblock', 'Add block'),
                'url'   => array('/contentblock/contentBlockBackend/create')
            ),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'ContentBlock.ContentBlockManager',
                'description' => Yii::t('ContentBlockModule.contentblock', 'Manage blocks'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.Create',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Creating block')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.Delete',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Removing block')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.Index',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'List of blocks')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.Update',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Editing blocks')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.Inline',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Editing blocks')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'ContentBlock.ContentblockBackend.View',
                        'description' => Yii::t('ContentBlockModule.contentblock', 'Viewing blocks')
                    ),
                )
            )
        );
    }
}
