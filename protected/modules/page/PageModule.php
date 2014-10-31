<?php

/**
 * PageModule основной класс модуля page
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page
 * @since 0.1
 *
 */
class PageModule extends yupe\components\WebModule
{
    const VERSION = '0.9';

    public function getDependencies()
    {
        return array(
            'user',
            'category',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('PageModule.page', 'Menu items order'),
            'editor'         => Yii::t('PageModule.page', 'Visual editor'),
            'mainCategory'   => Yii::t('PageModule.page', 'Main pages category'),
        );
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getEditableParams()
    {
        return array(
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->editors,
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
        );
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t('PageModule.page', 'Content');
    }

    public function getName()
    {
        return Yii::t('PageModule.page', 'Pages');
    }

    public function getDescription()
    {
        return Yii::t('PageModule.page', 'Module for creating and manage static pages');
    }

    public function getAuthor()
    {
        return Yii::t('PageModule.page', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('PageModule.page', 'team@yupe.ru');
    }

    public function getUrl()
    {
        return Yii::t('PageModule.page', 'http://yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-file";
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'application.modules.page.models.*',
                'application.modules.page.components.widgets.*',
            )
        );

        // Если у модуля не задан редактор - спросим у ядра
        if (!$this->editor) {
            $this->editor = Yii::app()->getModule('yupe')->editor;
        }
    }

    public function isMultiLang()
    {
        return true;
    }

    public function getAdminPageLink()
    {
        return '/page/pageBackend/index';
    }

    public function getNavigation()
    {
        return array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('PageModule.page', 'Pages list'),
                'url'   => array('/page/pageBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('PageModule.page', 'Create page'),
                'url'   => array('/page/pageBackend/create')
            ),
            array(
                'icon'  => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('PageModule.page', 'Pages categories'),
                'url'   => array('/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory)
            ),
        );
    }

    public function getAuthItems()
    {
        return array(
            array(
                'name'        => 'Page.PageManager',
                'description' => Yii::t('PageModule.page', 'Manage pages'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => array(
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.Create',
                        'description' => Yii::t('PageModule.page', 'Creating page')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.Delete',
                        'description' => Yii::t('PageModule.page', 'Removing page')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.Index',
                        'description' => Yii::t('PageModule.page', 'List of pages')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.Update',
                        'description' => Yii::t('PageModule.page', 'Editing pages')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.Inline',
                        'description' => Yii::t('PageModule.page', 'Editing pages')
                    ),
                    array(
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Page.PageBackend.View',
                        'description' => Yii::t('PageModule.page', 'Viewing pages')
                    ),
                )
            )
        );
    }
}
