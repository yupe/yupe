<?php

/**
 * DictionaryModule основной класс модуля dictionary
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.dictionary
 * @since 0.1
 *
 */
class DictionaryModule extends yupe\components\WebModule
{
    const VERSION = '0.9.2';

    public function getDependencies()
    {
        return [
            'user'
        ];
    }

    public function getParamsLabels()
    {
        return [
            'adminMenuOrder' => Yii::t('DictionaryModule.dictionary', 'Menu items order'),
        ];
    }

    public function getCategory()
    {
        return Yii::t('DictionaryModule.dictionary', 'Structure');
    }

    public function getName()
    {
        return Yii::t('DictionaryModule.dictionary', 'Dictionaries');
    }

    public function getDescription()
    {
        return Yii::t('DictionaryModule.dictionary', 'Module for simple dictionary');
    }

    public function getAuthor()
    {
        return Yii::t('DictionaryModule.dictionary', 'yupe team');
    }

    public function getAuthorEmail()
    {
        return Yii::t('DictionaryModule.dictionary', 'team@yupe.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-book";
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getAdminPageLink()
    {
        return '/dictionary/dictionaryBackend/index';
    }

    public function getNavigation()
    {
        return [
            ['label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries list'),
                'url'   => ['/dictionary/dictionaryBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Create dictionary'),
                'url'   => ['/dictionary/dictionaryBackend/create']
            ],
            ['label' => Yii::t('DictionaryModule.dictionary', 'Items')],
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('DictionaryModule.dictionary', 'Items list'),
                'url'   => ['/dictionary/dictionaryDataBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('DictionaryModule.dictionary', 'Create item'),
                'url'   => ['/dictionary/dictionaryDataBackend/create']
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'dictionary.models.*',
                'dictionary.components.*',
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'Dictionary.DictionaryManager',
                'description' => Yii::t('DictionaryModule.dictionary', 'Manage dictionary'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    //dictionary
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.Create',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Creating dictionary')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.Delete',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Removing dictionary')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.Index',
                        'description' => Yii::t('DictionaryModule.dictionary', 'List of dictionary')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.Update',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Editing dictionary')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.Inline',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Editing dictionary')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryBackend.View',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Viewing dictionary')
                    ],
                    //data
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.Create',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Creating dictionary data')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.Delete',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Removing dictionary data')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.Index',
                        'description' => Yii::t('DictionaryModule.dictionary', 'List of dictionary data')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.Update',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Editing dictionary data')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.Inline',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Editing dictionary data')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Dictionary.DictionaryDataBackend.View',
                        'description' => Yii::t('DictionaryModule.dictionary', 'Viewing dictionary data')
                    ],
                ]
            ]
        ];
    }
}
