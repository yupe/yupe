<?php
/**
 * HomepageModule основной класс модуля homepage
 *
 * @author Andrey Opeykin <hello@amylabs.ru>
 * @link http://amylabs.ru
 * @copyright 2013 amyLabs
 * @package yupe.modules.homepage
 * @since 0.1
 *
 */
Yii::import('application.modules.page.models.Page');
Yii::import('application.modules.blog.models.Post');

class HomepageModule extends yupe\components\WebModule
{
    const VERSION = '0.9.4';

    const MODE_POSTS = 1;

    const MODE_PAGE = 2;

    const MODE_STORE = 3;

    public $mode = 1;

    public $limit;

    public $target;

    public function getDependencies()
    {
        return [
            'blog',
            'page'
        ];
    }

    public function getModes()
    {
        $modes = [];
        if (Yii::app()->hasModule('blog')) {
            $modes[self::MODE_POSTS] = Yii::t('HomepageModule.homepage', 'Posts');
        }
        if (Yii::app()->hasModule('page')) {
            $modes[self::MODE_PAGE] = Yii::t('HomepageModule.homepage', 'Page');
        }
        if (Yii::app()->hasModule('store')) {
            $modes[self::MODE_STORE] = Yii::t('HomepageModule.homepage', 'Store');
        }
        if (empty($modes)) {
            $modes[null] = Yii::t('HomepageModule.homepage', 'Please activate "Blogs" or/and "Pages" module');
        }

        return $modes;
    }

    public function getTargets()
    {
        if ($this->mode == self::MODE_POSTS) {
            return CHtml::listData(Post::model()->public()->published()->findAll(), 'id', 'title');
        }

        if ($this->mode == self::MODE_PAGE) {
            return CHtml::listData(Page::model()->public()->published()->findAll(), 'id', 'title');
        }

        return [];
    }

    public function getName()
    {
        return Yii::t('HomepageModule.homepage', 'Home page');
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getCategory()
    {
        return Yii::t('HomepageModule.homepage', 'Structure');
    }

    public function getDescription()
    {
        return Yii::t('HomepageModule.homepage', 'Main page management module');
    }

    public function getAuthor()
    {
        return 'amylabs team';
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru';
    }

    public function getIcon()
    {
        return 'fa fa-fw fa-home';
    }

    public function getAdminPageLink()
    {
        return ['/yupe/backend/modulesettings', 'module' => 'homepage'];
    }

    public function getEditableParams()
    {
        return [
            'mode'   => $this->getModes(),
            'target' => $this->getTargets(),
            'limit'
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('HomepageModule.homepage', 'Main settings'),
                'items' => [
                    'mode',
                    'target',
                    'limit'
                ]
            ]
        ];
    }

    public function getParamsLabels()
    {
        return [
            'mode'   => Yii::t('HomepageModule.homepage', 'Whats will be displayed'),
            'limit'  => Yii::t('HomepageModule.homepage', 'Pages count'),
            'target' => Yii::t('HomepageModule.homepage', 'Page or post')
        ];
    }

    public function init()
    {
        parent::init();
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'ManageHomePage',
                'description' => Yii::t('HomepageModule.homepage', 'Manage home page'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'Homepage.YupeBackend.Modulesettings',
                        'description' => Yii::t('HomepageModule.homepage', 'Manage home page')
                    ],
                ]
            ]
        ];
    }
}
