<?php

/**
 * PageModule основной класс модуля page
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package yupe.modules.page
 * @since 0.1
 *
 */
class PageModule extends yupe\components\WebModule
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
            'user',
            'category',
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'editor' => Yii::t('PageModule.page', 'Visual editor'),
            'mainCategory' => Yii::t('PageModule.page', 'Main pages category'),
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
            'editor' => Yii::app()->getModule('yupe')->editors,
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
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
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('PageModule.page', 'Content');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('PageModule.page', 'Pages');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('PageModule.page', 'Module for creating and manage static pages');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return Yii::t('PageModule.page', 'yupe team');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('PageModule.page', 'team@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('PageModule.page', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-file';
    }

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'application.modules.page.models.*',
                'application.modules.page.components.widgets.*',
            ]
        );

        // Если у модуля не задан редактор - спросим у ядра
        if (!$this->editor) {
            $this->editor = Yii::app()->getModule('yupe')->editor;
        }
    }

    /**
     * @return bool
     */
    public function isMultiLang()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getAdminPageLink()
    {
        return '/page/pageBackend/index';
    }

    /**
     * @return array
     */
    public function getNavigation()
    {
        return [
            [
                'icon' => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('PageModule.page', 'Pages list'),
                'url' => ['/page/pageBackend/index'],
            ],
            [
                'icon' => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('PageModule.page', 'Create page'),
                'url' => ['/page/pageBackend/create'],
            ],
            [
                'icon' => 'fa fa-fw fa-folder-open',
                'label' => Yii::t('PageModule.page', 'Pages categories'),
                'url' => ['/category/categoryBackend/index', 'Category[parent_id]' => (int)$this->mainCategory],
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
                'name' => 'Page.PageManager',
                'description' => Yii::t('PageModule.page', 'Manage pages'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Page.PageBackend.Create',
                        'description' => Yii::t('PageModule.page', 'Creating page'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Page.PageBackend.Delete',
                        'description' => Yii::t('PageModule.page', 'Removing page'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Page.PageBackend.Index',
                        'description' => Yii::t('PageModule.page', 'List of pages'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Page.PageBackend.Update',
                        'description' => Yii::t('PageModule.page', 'Editing pages'),
                    ],
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Page.PageBackend.View',
                        'description' => Yii::t('PageModule.page', 'Viewing pages'),
                    ],
                ],
            ],
        ];
    }
}
